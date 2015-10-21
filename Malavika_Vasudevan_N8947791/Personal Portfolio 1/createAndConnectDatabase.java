import java.sql.Connection;
import java.sql.DriverManager;
// SQL statements
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
// Components
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import javax.swing.text.html.HTMLDocument.Iterator;

// Referenced from code developed in IAB130.

public class Assessment1c {

	static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";  
	// Address of the database.
	static final String DATABASE_URL = "jdbc:mysql://localhost/";
	static final String DATABASE_NAME = "MediaVault";
	static Connection connection=null;
	static PreparedStatement preparedStatement=null;
	static ResultSet resultSet = null;
	// The admin's username and password is entered.
	static final String USERNAME = "username";
	static final String PASSWORD = "password";


		/*
		 * Creates a database
		 * */
		public static void createDatabase() throws SQLException, ClassNotFoundException {
			String myDriver = "com.mysql.jdbc.Driver";
			Class.forName(myDriver);
			connection =  DriverManager.getConnection(DATABASE_URL, USERNAME, PASSWORD);
			Statement statement = connection.createStatement();
			statement.executeUpdate("CREATE DATABASE IF NOT EXISTS " + DATABASE_NAME + ";");
			statement.close();
			System.out.println("Database is created.");
		}	

		
		/*
		 * Cleans the table
		 * */
		public static void cleanTable(String tableName) throws SQLException, ClassNotFoundException {
			Statement statement = connection.createStatement();
			statement.executeUpdate("DROP TABLE IF EXISTS " + tableName + ";");
			statement.close();
			System.out.println("Table "+ tableName + " is cleaned successfully...");
		}
		
		
		/*
		 * Connects to the database
		 * */
		public static void connectToDatabase() throws SQLException, ClassNotFoundException {
			//Register JDBC driver
			String myDriver = "com.mysql.jdbc.Driver";
			Class.forName(myDriver);
			
			connection =  DriverManager.getConnection(DATABASE_URL + DATABASE_NAME, USERNAME, PASSWORD);
			Statement statement = connection.createStatement();
			statement.executeUpdate("CREATE DATABASE IF NOT EXISTS " + DATABASE_NAME + ";");
			System.out.println("Connected to the database.");
		}


	/**
	 * @param args
	 * @throws SQLException 
	 * @throws ClassNotFoundException 
	 */
	public static void main(String[] args) throws ClassNotFoundException, SQLException {

		createDatabase();
		connectToDatabase();
		cleanTable("Users"); 
		if(connection.isClosed())
			connect();
		String createTable = "CREATE TABLE IF NOT EXISTS Comments"
				+ "username VARCHAR(100) NOT NULL,"
				+ "email VARCHAR(45),"
				+ "password VARCHAR(45)"
				+ "PRIMARY KEY(username));";
        
		System.out.println("Create table");
		Statement statement = connection.createStatement(); 
	    statement.executeUpdate( createTable ); 
		
		connection.close();
	}

}


