INSERT INTO Users (Name, Email, Password, Picture, Role)
  VALUES
  ("Soso l'asticot", 'superkiwi@gmail.com', 'nootroot', 'https://avatars.githubusercontent.com/u/47189868?v=4', 'admin'),
  ("Soso moineau", 'paskiwi@gmail.com', 'nootroot', 'https://avatars.githubusercontent.com/u/9848478?v=4', 'user'),
  ("anjala", 'anjala2022@gmail.com', 'anjala123', 'https://avatars.githubusercontent.com/u/47189868?v=4', 'admin'),
  ("devin", 'devin@gmail.com', 'devin1', 'https://avatars.githubusercontent.com/u/9848478?v=4', 'user');
INSERT INTO Blogs (Title, Description, Date_creation, Background_image, idUsers)
 VALUES
 ("J'aime trop les kiwi", "Harry Styles m'a inspirer un mode vie basé sur les fruits, je veux danser sous des pluies de sirop de pasteques et dormir
 sur des lits de grenades", '2022-04-11', 'https://cdn.pixabay.com/photo/2017/07/25/18/47/kiwi-2539135_1280.jpg', 2),
 ("Harmonie Corps et Esprit","Explorez l'art ancien du yogo pour cultiver l'harmonie enter votre crops et votre esprit. Découvertez des partiques, des conseils et des inspirations pour nourir votre bien-être intérieur",'2022-04-11','https://media.istockphoto.com/id/1010036252/fr/vectoriel/la-m%C3%A9ditation-humaine-en-posture-de-lotus-illustration-de-yoga.jpg?s=612x612&w=0&k=20&c=dGOeGvzKNRbXE3P96Kat89XoUFN-sSHK-RQNrG8z8OU=', 3),
 ("L'écrivain Passionné","Bienvenue sur mon espace d'ecriture, ou les mots prennent vie. En tant qu'écrivain passionné , je partage ici mes réflexions, histoire et découvertes. Joignez-vous à moi dans cette eventure littéraire ou chaque article est une exploration du monde à travers les lentilles de l'écriture",'2022-04-11',"https://media.istockphoto.com/id/134222874/fr/photo/ecrivain.jpg?s=1024x1024&w=is&k=20&c=HYhDzDTBiTAJhgC6unAjwjc_nCDZVu4HRNd4_Wy_aYk=", 3),
 ("Le Curieux Explorateur","En tant qu'explorateur curieux, je vous invite à plonger dans les profondeurs de la connaissance et de l'inscription. Chaque article est une nouvelle exploration, une opportunité de découvrir des idées fascinantes et de paetager ensamble cette quêt de savoir. Bienvenue dans mon monde de découvertes intellectuels!",'2022-04-11',"https://images.pexels.com/photos/840667/pexels-photo-840667.jpeg?cs=srgb&dl=pexels-oziel-g%C3%B3mez-840667.jpg&fm=jpg", 3);


 

 INSERT INTO Tags (Tag_Name, idUsers)
 VALUES
  ("Fruits", 1),
  ("Harry Styles", 1),
  ("Programmation informatique", 1),
  ("Jeux-vidéos", 1),
  ("Cuisine", 1);