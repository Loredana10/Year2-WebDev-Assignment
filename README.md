# Year2-WebDev-Assignment
The aim of this assignment is to develop a book reservation web site using PHP and MySQL database. The application will allow users to search for and reserve library books. Specifically, the application will enable the following:

## Library Functionality

* Search for a book
* Reserve a book
* View all the books that they have reserved

## Login

* The user must identify themselves to the system in order to use the system and throughout the whole site. If they have not previously used the system, they must register their details.

## Registration

* This allows a user to enter their details on the system. The registration process should validate that all details are entered. Mobile phone numbers should be numeric and 10 characters in length. Password should be six characters and have a password confirmation function. The system should ensure that each user can be identified using a unique username.

## Search for a Book

* The system should allow the user to search in a number of ways:
  - by book title and/or author (including partial search on both)
  - by book category description in a dropdown menu (book category should be retrieved from the database)

* The results of the search should display as a list from which the user can then reserve a book if available. If the book is already reserved, the user should not be allowed to reserve the book.

## Reserve a Book

* The system should allow a user to reserve a book provided that no one else has reserved the book yet. The reservation functionality should capture the date on which the reservation was made.

## View Reserved Books

* The system should allow the user to see a list of the book(s) currently reserved by that user. Users should be able to remove the reservation as well.

## Notes

* Apart from HTML, you should try to use other client-side technologies like cascading style sheets to make pages neat and tidy. All validation should be server-side.
* Do not allow for more than 5 rows of data per page, where search results are being displayed.
* Include functionality to display lists across more than one page.
* The screens should be neat, with a simple design and usable. They do not need to be overly elaborate in presentation as you will not get extra marks for this.

## Other Requirements

* You must create/duplicate the database given in this document. You can add more data as you need to the tables.
* Use a common header and footer for your pages throughout the application
* Avoid hard-coding in your programs
* Include error checking as appropriate

## Database

* The book database contains four tables:
  - Users table - to hold user registration and password details. Each user is uniquely identified by a username.


