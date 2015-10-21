// Author: Malavika Vasudevan
// Student Number: N8947791
// References: CAB403 Tutorials
// This file contains the main source code for the client-end communication.

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

#define MAXSIZE 1024

int main( int argc, char ** argv )
{
	// Connector's address information.
    struct sockaddr_in their_addr;
    struct hostent *he;
    int socket_fd, numbytes;
    char buff[ MAXSIZE ];

	if ( argc != 3 ) {
		fprintf(stderr, "Please enter the client hostname and port number\n" );
		exit(1);
	}
	
	// Get the host information.
    if ( ( he = gethostbyname( argv[ 1 ] ) ) == NULL ) {
		herror("Cannot get hostname.");
        exit(1);
    }

    if ( ( socket_fd = socket( AF_INET, SOCK_STREAM, 0 ) ) == -1 ) {
		perror( "Socket Failure.\n" );
        exit(1);
    }

    memset( &their_addr, 0, sizeof( their_addr ) );
    their_addr.sin_family = AF_INET;
    their_addr.sin_port = htons( atoi( argv[ 2 ] ) )	;
    their_addr.sin_addr = *( (struct in_addr *)he->h_addr) ;
	
    if ( connect( socket_fd, (struct sockaddr *)&their_addr, sizeof( struct sockaddr ) ) < 0 ) {
        perror( "Connection Failure.\n" );
		close( socket_fd );
        exit( 1 );
    }
	// Close the socket.
    close(socket_fd);
	
	return 0;

}//End of main