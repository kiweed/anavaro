Number of extensions for PhpBB 3.1

Event Medals

  Description:
  
    Event Medals is a extension for PhpBB3 that adds support for event awards. 
	It is developed as a way to give awards in user profiles for attending live meetings. 
	But can be used for much more.
    
  Features:
    
    Forum:
      -show summary of user medals in profile field in postview - NOT CONFIGURABLE
    
    Profile:
      -show list user medals in profile - CONFIGURABLE (configuration is NOT IMPLEMENTED yet)
      -show form for manual adding of madels to admins - NOT IMPLEMENTED
	  -TO DO: Quick Delete/edit of medals
      
    UCP:
      -show ACL for who can view the medals in profile (Allways visible for admins and user it self) - NOT IMPLEMENTED
      
    ACP:
      -form for mass addition of medals
	  -make sure medals are unique
	  -edit medals
	  -TO DO: Make ACL who can add medals

	  
Zebra enchance

  Description:
  
    Enhances PhpBB Zebra module adding additional ACL level.
	Adds support for friend request need to be approved.
	Adds addition level of friends - hidden mark for special friends.
	Adds beautiful friend control.
	
  Features:
  
    System:
	  - TO DO: Make sure AJAX Callback function is loaded only in UCP -> Zebra
	
	UCP:
	  - Show pending and awaiting confirmation requests
	  - Show beautiful friend control (using AJAX)
	  - Add option for selecting "Close Friends" with additional access*
	  - TO DO: Dynamically locate which is the zebra modile
	  - TO DO: Make cancel request use AJAXed "confirm_box" (there is bug with confirm submit when executed from ajax)
	  - TO DO: See if when user is deleted zebra cleans the remains (if not - make the extension do it)
	  
	ACP:
	  - TO DO: Add ACL options