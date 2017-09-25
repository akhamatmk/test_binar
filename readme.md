1 . saya mendesaign dengan aplikasi lument karena lebih kecil aplikasinya dan simple karena tidak butuh tampilan hanya json yang disampaikan  



2 . dengan cara data di buat harus sama dengan format request dan client harus ngasih token setiap request sehingga apabila tidak membawa token maka system atau backend akan menolak request dari client dan jika kalau format data yang ikirim tidak sesuai dengan apa yang ditentukan maka server akan menolak dengan balikan seperti ini

3.



Maksut dari pake header adalah 
Authorization:Bearer {token jwt anda pas dapet dari login}


akses
login
https://akhamat.herokuapp.com/maker/add/login?c={"data":{"email": "akhamat@mifx.com","password":"secret","radius":"23"},"meta":{"cursor":{"count":10,"previous":null,"current":null},"location":[134.90438543,-185.485439],"language":"id","app":"desktop","timestamp":1502981540}}




get marker

https://akhamat.herokuapp.com/maker/get/login?c={"data":{"email": "akhamat@mifx.com","password":"secret","radius":"23"},"meta":{"cursor":{"count":10,"previous":null,"current":null},"location":[134.90438543,-185.485439],"language":"id","app":"desktop","timestamp":1502981540}}



get marker spesific

https://akhamat.herokuapp.com/maker/data/{idnya brapa}/login?c={"data":{"email": "akhamat@mifx.com","password":"secret","radius":"23"},"meta":{"cursor":{"count":10,"previous":null,"current":null},"location":[134.90438543,-185.485439],"language":"id","app":"desktop","timestamp":1502981540}}




Add marker  ini pake header auth

method post
 https://akhamat.herokuapp.com/maker/add
params 
 c={"data":{"email": "akhamat@mifx.com","password":"secret","radius":"23"},"meta":{"cursor":{"count":10,"previous":null,"current":null},"location":[134.90438543,-185.485439],"language":"id","app":"desktop","timestamp":1502981540}}


 edit marker  ini pake header auth

method put
 https://akhamat.herokuapp.com/maker/getPut/{id nya}
params 
 c={"data":{"email": "akhamat@mifx.com","password":"secret","radius":"23"},"meta":{"cursor":{"count":10,"previous":null,"current":null},"location":[134.90438543,-185.485439],"language":"id","app":"desktop","timestamp":1502981540}}

 delete marker  ini pake header auth

method delete
 https://akhamat.herokuapp.com/maker/delete/{idnya brapa}
params 
 c={"data":{"email": "akhamat@mifx.com","password":"secret","radius":"23"},"meta":{"cursor":{"count":10,"previous":null,"current":null},"location":[134.90438543,-185.485439],"language":"id","app":"desktop","timestamp":1502981540}}








GET PROFILE => Gak pake header
example	= https://akhamat.herokuapp.com/profile?c={"data":{"token_gg":"PyFhkbEXu1TwAwtTt4wolK2FBm8G50","email":"irawan_ferry@rocketmail.com"},"meta":{"location":[134.90438543,-185.485439],"language":"id","timestamp":1503564809}}



GET PROFILE => Gak pake header
example	= https://akhamat.herokuapp.com/profile?c={"data":{"token_gg":"PyFhkbEXu1TwAwtTt4wolK2FBm8G50","email":"irawan_ferry@rocketmail.com"},"meta":{"location":[134.90438543,-185.485439],"language":"id","timestamp":1503564809}}
	
	
GET MARKERS (PLACE, COMUNITY, PEOPLE) => pake header
	Example =  https://akhamat.herokuapp.com/long?c={"data":{"lat":37,"long":-122,"radius":30},"meta":{"location":[134.90438543,-185.485439],"language":"id","timestamp":1503564809}}

DETAIL (PLACE / COMUNITY) =>  pake header ada params marker_id sama type
	Example = 
Place 
https://akhamat.herokuapp.com/detail?c={"data":{"marker_id":2,"type":1},"meta":{"location":[134.90438543,-185.485439],"language":"id","timestamp":1503564809}}

Comunity
		https://akhamat.herokuapp.com/detail?c={"data":{"marker_id":12,"type":2},"meta":{"location":[134.90438543,-185.485439],"language":"id","timestamp":1503564809}}

GET COMMENT ALL => pake header dan ada place_id	https://akhamat.herokuapp.com/comments/place?c={"data":{"place_id":2},"meta":{"location":[134.90438543,-185.485439],"language":"id","timestamp":1503564809}}
	
GET ALL PHOTO
Pleace
https://akhamat.herokuapp.com/place/photo/all?c={"data":{"place_id":2},"meta":{"location":[134.90438543,-185.485439],"language":"id","timestamp":1503564809}}

 
Community		akhamat.herokuapp.com/community/photo/all?c={"data":{"community_id":12},"meta":{"location":[134.90438543,-185.485439],"language":"id","timestamp":1503564809}}



GET ALL PLACE
	
https://akhamat.herokuapp.com/place/all?c={"data":{"long":"-122","lat":"37","radius":"23"},"meta":{"cursor":{"count":10,"previous":null,"current":null},"location":[134.90438543,-185.485439],"language":"id","app":"desktop","timestamp":1502981540}}
