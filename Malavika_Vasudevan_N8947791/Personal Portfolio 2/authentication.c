/**
  * File: authentication_hangman.c 
  * Author: Malavika Vasudevan
  * Student Number: n8947791
  * This file contains the implementation for authentication.
  */
  
// Declare users struct.
typedef struct users {
	// The username of the client.
	char username[ 100 ];
	// The password of the client.
	unsigned long password;
} users_t;


// Declare registered users array.
users_t registered_users[ NUM_OF_USERS ];
// Fill the array of structs with users.
void fill_array_of_registered_users( void ) {
	// Declare file pointer.
   FILE * fp;

   // Open file for reading.
   fp = fopen( "Authentication.txt", "r" );
   
   if( fp == NULL ) 
   {
      perror( "Error opening file" );
      exit( 1 );
   }	
   
   // Store the username and passwords of the users.
   read_username_and_password( fp );

   // Close the file after use.
   fclose( fp );

}

// Read username and password from the file.
void read_username_and_password( FILE * fp ) {
	int count = 0;
   // Declare the size of the string stored.
	int buffer_size = 100;
	// Set the variable to store the line in.
	char buffer[ buffer_size ];
	// Index of the array member.
	int  index = 0;
	// Get the line
	while ( fgets ( buffer, buffer_size, fp ) != NULL ) {
		if ( count == 0 ) {
			count++;
		} else {
			// Tokenize string.
			strcpy( registered_users[ index ].username,  strtok( buffer, "\t" ) );	
			// Declare variable to store the password.
			char ptr[ buffer_size ];
			// Store the password in string format first.
			strcpy( ptr, strtok( NULL, "\t" ) );
			
			// Trim the password whitespaces.
			// The following boolean variable states whether the password string is trimmed or not.
			bool trimmed = false;	
			// Go through each character of the password string.
			int password_index = 0;
			// Go through the loop till password is not free of whitespaces.
			while( !trimmed) {
				// Check for whitespace
				if ( ptr[ password_index ] == ' ' ) {
					// If whitespace is found, replace that with the end of string character.
					ptr[ password_index ] == '\0';
					// The password is now trimmed.
					trimmed = true;
				}
				// Increase index of the password string.
				password_index++;				
			}

			// Store the passwords.
			registered_users[ index ].password = atol( ptr ); 
			
			// Increase the index.
			index++;			
		}	

	}
	
	// Since some of the usernames contains whitespaces, we should remove it.
	for ( int i = 0; i < NUM_OF_USERS; i++ ) {
		// Check for whitespace.
		if ( registered_users[ i ].username[ strlen( registered_users[ i ].username ) - 1 ] == ' ' ) {
			// Whitespace found.Thus replace the character with end of string character.
			registered_users[ i ].username[ strlen( registered_users[ i ].username ) - 1 ] = '\0';
		}		
	}
	
}

// Authenticates the user. Returns true if the user is registered and false if the user is not registered.
bool authenticate_user( char * given_username, long given_password ) {
	
		for ( int k = 0; k < NUM_OF_USERS; k++ ) {
			if ( strcmp( registered_users[ k ].username, given_username ) == 0 ) {
				if ( registered_users[ k ].password == given_password ) {
					return true;
				}
			}			
		}
	
	return false;
}
