adImages = new Array("images/moving1.jpg", "images/moving2.jpg", "images/moving3.jpg", "images/moving4.jpg")    
   thisAd = 0                      
   imgCt = adImages.length 
     
     function rotate()
     {
       if (document.images)
       {
        thisAd++                   
        if (thisAd == imgCt)    
         { thisAd = 0  }
        document.getElementById("adBanner").src=adImages[thisAd] 
        setTimeout("rotate()", 3 * 1000)  
       }
      }//End function