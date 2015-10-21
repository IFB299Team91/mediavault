// Author: Malavika Vasudevan
// Student Number: N8947791
// References: CAB403 Tutorials
// This file contains the main source code for the server-end communication.

#define _GNU_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <string.h>
#include <netdb.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <stdbool.h>
#include <pthread.h>// pthread functions and data structures.
#include <math.h>
#include <signal.h>

#include "hangman_game.h"

#define DEFAULT_PORT_NUMBER 12345
#define BACKLOG 10

#define NUM_OF_USERS 10

// Number of threads used to service client requests.
#define NUM_HANDLER_THREADS 10


// Global variable, purely used for deallocation.
game_t * new_game;
// Server and client sockets.
int server_fd;
int user_fd[ NUM_OF_USERS ];

// Pointer to the pthread array.
pthread_t * pt;

/* global mutex for our program. assignment initializes it. 
 * note that we use a RECURSIVE mutex, since a handler      
 * thread might try to lock it twice consecutively.         
 */
 
pthread_mutex_t request_mutex = PTHREAD_RECURSIVE_MUTEX_INITIALIZER_NP;

/* global condition variable for our program. assignment initializes it. */
pthread_cond_t  got_request   = PTHREAD_COND_INITIALIZER;

int num_requests = 0;   /* number of pending requests, initially none */

/* format of a single request. */
struct request {
    int number;             /* number of the request                  */
    struct request* next;   /* pointer to next request, NULL if none. */
	int client_fd;
};

struct request* requests = NULL;     /* head of linked list of requests. */
struct request* last_request = NULL; /* pointer to last request.  */


// Signal Handler
void signal_handler( int sig );
/*
 * function add_request(): add a request to the requests list
 * algorithm: creates a request structure, adds to the list, and
 *            increases number of pending requests by one.
 * input:     request number, linked list mutex.
 * output:    none.
 */
void add_request(int request_num, int client_fd,
            pthread_mutex_t* p_mutex,
            pthread_cond_t*  p_cond_var)
{
    int rc;                         /* return code of pthreads functions.  */
    struct request* a_request;      /* pointer to newly added request.     */

    /* create structure with new request */
    a_request = (struct request*)malloc(sizeof(struct request));
    if (!a_request) { /* malloc failed?? */
        fprintf(stderr, "add_request: out of memory\n");
        exit(1);
    }
    a_request->number = request_num;
	a_request->client_fd = client_fd;
    a_request->next = NULL;

    /* lock the mutex, to assure exclusive access to the list */
    rc = pthread_mutex_lock(p_mutex);

    /* add new request to the end of the list, updating list */
    /* pointers as required */
    if (num_requests == 0) { /* special case - list is empty */
        requests = a_request;
        last_request = a_request;
    }
    else {
        last_request->next = a_request;
        last_request = a_request;
    }

    /* increase total number of pending requests by one. */
    num_requests++;

    /* unlock mutex */
    rc = pthread_mutex_unlock(p_mutex);

    /* signal the condition variable - there's a new request to handle */
    rc = pthread_cond_signal(p_cond_var);
}

/*
 * function get_request(): gets the first pending request from the requests list
 *                         removing it from the list.
 * algorithm: creates a request structure, adds to the list, and
 *            increases number of pending requests by one.
 * input:     request number, linked list mutex.
 * output:    pointer to the removed request, or NULL if none.
 * memory:    the returned request need to be freed by the caller.
 */
struct request* get_request(pthread_mutex_t* p_mutex)
{
    int rc;                         /* return code of pthreads functions.  */
    struct request* a_request;      /* pointer to request.                 */

    /* lock the mutex, to assure exclusive access to the list */
    rc = pthread_mutex_lock(p_mutex);

    if (num_requests > 0) {
        a_request = requests;
        requests = a_request->next;
        if (requests == NULL) { /* this was the last request on the list */
            last_request = NULL;
        }
        /* decrease the total number of pending requests */
        num_requests--;
    }
    else { /* requests list is empty */
        a_request = NULL;
    }

    /* unlock mutex */
    rc = pthread_mutex_unlock(p_mutex);

    /* return the request to the caller. */
    return a_request;
}

/*
 * function handle_request(): handle a single given request.
 * algorithm: prints a message stating that the given thread handled
 *            the given request.
 * input:     request pointer, id of calling thread.
 * output:    none.
 */
void handle_request( struct request* a_request, int thread_id )
{
    if (a_request) {
		int client_fd = a_request->client_fd;
        // Assign client fd to global variable.
        user_fd[ thread_id ] = client_fd;			
		//Close Connection Socket
		close( client_fd );
		// Set it back to -1.
		user_fd[ thread_id ] = -1;
    }
}

/*
 * function handle_requests_loop(): infinite loop of requests handling
 * algorithm: forever, if there are requests to handle, take the first
 *            and handle it. Then wait on the given condition variable,
 *            and when it is signaled, re-do the loop.
 *            increases number of pending requests by one.
 * input:     id of thread, for printing purposes.
 * output:    none.
 */
void* handle_requests_loop(void* data)
{
    int rc;                         /* return code of pthreads functions.  */
    struct request* a_request;      /* pointer to a request.               */
    int thread_id = *((int*)data);  /* thread identifying number           */


    /* lock the mutex, to access the requests list exclusively. */
    rc = pthread_mutex_lock(&request_mutex);

    /* do forever.... */
    while (1) {

        if (num_requests > 0) { /* a request is pending */
            a_request = get_request(&request_mutex);
            if (a_request) { /* got a request - handle it and free it */
                /* unlock mutex - so other threads would be able to handle */
                /* other reqeusts waiting in the queue paralelly.          */
                rc = pthread_mutex_unlock(&request_mutex);
                handle_request(a_request, thread_id);
                free(a_request);
                /* and lock the mutex again. */
                rc = pthread_mutex_lock(&request_mutex);
            }
        }
        else {
            /* wait for a request to arrive. note the mutex will be */
            /* unlocked here, thus allowing other threads access to */
            /* requests list.                                       */

            rc = pthread_cond_wait(&got_request, &request_mutex);
            /* and after we return from pthread_cond_wait, the mutex  */
            /* is locked again, so we don't need to lock it ourselves */

        }
    }
}

 
int main( int argc, char ** argv )
{
	// Signal handler for Ctrl+C
	signal( SIGINT, signal_handler );	
	// Thread id's, each of type int.
    int thr_id[ NUM_HANDLER_THREADS ];   
	// Array of thread structures.
    pthread_t  p_threads[ NUM_HANDLER_THREADS ];   
	// Used for wasting time.
    struct timespec delay;                      

	// Assigning the address to a global variable.
	pt = &p_threads[ 0 ];
	// Create the request-handling threads.
    for ( int i=0; i < NUM_HANDLER_THREADS; i++ ) {
        thr_id[ i ] = i;
		// Creating 10 threads with thread structure, function that starts with each thread is handle_requests_loop and we are passing the thread_id as parameter.
        pthread_create( &p_threads[ i ], NULL, handle_requests_loop, (void*)&thr_id[ i ] );
		user_fd[ i ] = -1;
    }

	// SERVER - MULTITHREADING USING THREADPOOL
	// 1. Create a threadpool of 10 threads and each thread calling handle_requests_loop method.
	// 2. Set up the server socket, listening and wait for a client.
	// 3. After client is connected to the server, we call the add_request function with the client number.
	
	// Listen on socket_fd. 
	int socket_fd;
	// My address ( Server's ) information
    struct sockaddr_in my_addr;
 
    socklen_t size;

    int yes = 1;

	// Port number
	int port_number;
	
	// Get the port number if specified
	if ( argc != 2 ) {
		port_number = DEFAULT_PORT_NUMBER;
	} else if ( argc == 2 ) {
		// Port number is given to the server.
		port_number = atoi( argv[ 1 ] );
	}

	// Generate the socket
    if ( ( socket_fd = socket( AF_INET, SOCK_STREAM, 0 ) ) == -1 ) {
		// Error occured while generating a socket
		perror( "Socket generation failure.\n" );
		exit( 1 );
    }

    if ( setsockopt( socket_fd, SOL_SOCKET, SO_REUSEADDR, &yes, sizeof( int ) ) == -1 ) {
        perror( "Error in setsockopt.\n" );
        exit( 1 );
    }
    memset( &my_addr, 0, sizeof( my_addr ) );
	// Generate the end point
	// Host byte order	
    my_addr.sin_family = AF_INET;
	// Short network byte order
    my_addr.sin_port = htons( port_number );
	// Auto-fill with my IP
    my_addr.sin_addr.s_addr = INADDR_ANY; 
	// Bind the socket to the end point
    if ( ( bind( socket_fd, (struct sockaddr *)&my_addr, sizeof( struct sockaddr ) ) ) == -1 )    { 
		perror( "Binding failure\n" );
		exit( 1 );
    }

	printf( "\nServer: Filling array of clients..." );
	// Initialise array list
	fill_array_of_registered_users( );
	// Start listening 
    if ( ( listen( socket_fd, BACKLOG ) ) == -1 ){
		perror( "Listening failure\n" );
		exit( 1 );
    }
	
	// Listening successful.
	printf( "\nServer: Server starts listening..." );	
	
	// Assign value to global server socket.
	server_fd = socket_fd;	
	
	// This variable represents the request number.
	static int counter = 0;


	// This represents the thread number.
	
	// Repeat: Accept, send and close the connection
	// For every accepted connection, use a seperate process or thread to
	// serve the client.
	// Main accept( ) loop	
    while( 1 ) {

		// Connector's address ( Client's ) information
		struct sockaddr_in their_addr;   	
		// New connection on client_fd.
		int client_fd;
		memset( &their_addr,0,sizeof( their_addr ) );
        size = sizeof( struct sockaddr_in );
 
        if ( ( client_fd = accept( socket_fd, (struct sockaddr *)&their_addr, &size ) ) ==-1 ) {
            perror( "Accept failure.\n" );
            exit( 1 );
        }
		
		int connections = 0;
		for ( int i = 0; i < NUM_HANDLER_THREADS; i++ ) {
			if ( user_fd[ i ] != -1 ) {
				connections++;
			}
		}
		
		if ( connections < NUM_HANDLER_THREADS ) {
			// Got connection.
			printf( "\nServer : Got connection from client %s\n", inet_ntoa( their_addr.sin_addr ) );
			
			add_request( counter, client_fd, &request_mutex, &got_request );
			// Increase the number of requests.
			counter++;			
		} else {
			close( client_fd );
		}
		

    }  // end of while loop.

	// Close the server socket.
    close( socket_fd );	
    
    return 0;
} //End of main

void signal_handler( int sig )
{
    signal(sig, SIG_IGN);
    printf( "\nServer: Disconnecting...\n");
	for ( int i = 0; i < NUM_HANDLER_THREADS; i++ ) {
		 // Close the client socket.
		 if ( user_fd[ i ] != -1 ) {
			close( user_fd[ i ] );
			// Join the threads.
			pthread_join( *( pt + i ), NULL ); 			
		 }  
	}

    // Close the server socket.
    close( server_fd );
    exit( 1 );
}
