Number of extensions for PhpBB 3.1

Event Medals

  Description:
  
    Event Medals is a extension for PhpBB3 that adds support for event awards. 
	It is developed as a way to give awards in user profiles for attending live meetings. 
	But can be used for much more.
    
  Features:
    
    Forum:
      -show summary of user medals in profile field in postview
    
    Profile:
      -show list user medals in profile
      -show form for manual adding of madels ACL users
	  -TO DO: Return to user profile after adding a medal
      
    UCP:
      -show ACL for who can view the medals in profile (Allways visible for admins and user it self)
      
    ACP:
      -form for mass addition of medals
	  -make sure medals are unique
	  -edit medals
	  -ACL who can add/edit medals
	  -Split Add and EDIT ACL
	  -Edit image of medals
	  
  Global TO DO:
    Optimize and Clean code.
	  
Zebra enhance

  Description:
  
    Enhances PhpBB Zebra module adding additional ACL level.
	Adds support for friend request need to be approved.
	Adds addition level of friends - hidden mark for special friends.
	Adds beautiful friend control.
	
  Features:
  
    System:
	  - Make sure AJAX Callback function is loaded only in UCP -> Zebra
	  - Add notifications for new requests.
	
	UCP:
	  - Show pending and awaiting confirmation requests
	  - Show beautiful friend control (using AJAX)
	  - Add option for selecting "Close Friends" with additional access*
	  - Dynamically locate which is the zebra module
	  - Cancel request use AJAXed "confirm_box"
	  - See if when user is deleted zebra cleans the remains (if not - make the extension do it)
	  - Add ACL who can view friendlist
	  
	Profile:
	  - Add friend list in profile

  Global TO DO:
    Optimize and Clean code.

Post Love
  
  Description:
  
	Add "like"/love (as it uses small heart) to the posts. 
	As a popup you can see who have liked/loved the post.
	
  Features:
    
	Postview:
	  - Show small heart under every post 
	  - Togle like/love
	  - Show as tooltip who have loked the post