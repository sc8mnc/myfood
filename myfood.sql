-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2022 at 10:39 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myfood`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllRecipesBasicInfo` ()  SELECT R.recipe_name, R.ingredients, P.picture
FROM recipes R NATURAL JOIN recipe_pictures P
WHERE R.recipe_id = P.recipe_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllRecipesBasicInfoFromId` (`user_id` INT)  SELECT R.recipe_name, R.ingredients, P.picture
FROM recipes R, recipe_pictures P
WHERE R.recipe_id = P.recipe_id AND R.recipe_id = user_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `board_message`
--

CREATE TABLE `board_message` (
  `message_id` int(11) NOT NULL,
  `message_text` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `board_message`
--

INSERT INTO `board_message` (`message_id`, `message_text`, `timestamp`) VALUES
(1, 'I made some awesome pancakes today!', '2022-10-21 08:37:29'),
(2, 'Trying some of the new salads on this site this week! Will be commenting on them soon', '2022-10-21 08:37:29'),
(3, 'I found a great recipe, will upload soon!!', '2022-10-21 08:37:29'),
(4, 'The baked feta pasta was delicious! Totally recommend it to everyone.', '2022-10-21 08:37:29'),
(5, 'Please try my recipe, it is so easy!!', '2022-10-21 08:37:29'),
(6, 'Hi foodies! I will be traveling this week to Europe and will be posting some of the best dishes I try. Stay alert to find out more about these.', '2022-10-21 08:37:29'),
(7, 'Finals week! Trying all the quick recipes over the week!!!', '2022-10-21 08:37:29'),
(8, 'Summer break recipes must be comfort food', '2022-10-21 08:37:29'),
(9, 'I will be posting my new sandwich recipe soon! I found this new ingredient that will make this sandwich so different!', '2022-10-21 08:37:29'),
(10, 'Didn’t have time to try any new recipes today, so busy with work :(', '2022-10-21 08:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `board_pictures`
--

CREATE TABLE `board_pictures` (
  `message_id` int(11) NOT NULL,
  `picture` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `board_pictures`
--

INSERT INTO `board_pictures` (`message_id`, `picture`) VALUES
(1, 0x70616e63616b65732e6a7067),
(2, 0x73616c61642e6a7067),
(3, 0x70617374612e6a7067),
(4, 0x736d696c65795f666163652e6a7067),
(5, 0x6567675f73616c61642e6a7067),
(6, 0x70617269735f706963747572652e6a7067),
(7, 0x66696e616c732e6a7067),
(8, 0x636f6d666f72745f666f6f642e6a7067),
(9, 0x6578636974696e672e6a7067),
(10, 0x627573792e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `recipe_id` int(11) NOT NULL,
  `comment_number` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comment_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`recipe_id`, `comment_number`, `timestamp`, `comment_text`) VALUES
(1, 1, '2022-10-21 08:37:29', 'This recipe is awesome!!!'),
(1, 2, '2022-10-21 08:37:29', 'This recipe is ok…'),
(2, 3, '2022-10-21 08:37:29', 'Could you be more specific about the amount of salt to add?'),
(3, 4, '2022-10-21 08:37:29', 'How did you make that??'),
(4, 5, '2022-10-21 08:37:29', 'I think some other sauce would go better with this salad!'),
(5, 6, '2022-10-21 08:37:29', 'How did you make that??'),
(10, 7, '2022-10-21 08:37:29', 'I needed more sugar for mine lol'),
(15, 8, '2022-10-21 08:37:29', 'This is my first time seeing this recipe, thank you!'),
(19, 9, '2022-10-21 08:37:29', 'This recipe is not spicy enough for me haha'),
(20, 10, '2022-10-21 08:37:29', 'First time trying this drink, not so bad!');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`recipe_id`, `user_id`) VALUES
(1, 2),
(1, 3),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(10, 7),
(12, 8),
(13, 9),
(16, 10);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `user_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`user_id`, `message_id`) VALUES
(1, 1),
(1, 4),
(2, 2),
(3, 3),
(4, 5),
(6, 6),
(8, 7),
(8, 8),
(9, 9),
(9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `recipe_id` int(11) NOT NULL,
  `recipe_name` varchar(255) DEFAULT NULL,
  `ingredients` varchar(255) DEFAULT NULL,
  `cost` decimal(6,2) DEFAULT NULL,
  `instructions` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`recipe_id`, `recipe_name`, `ingredients`, `cost`, `instructions`) VALUES
(1, 'Spaghetti', 'Noodles, tomato sauce', '6.99', 'Set the water to boil, put in the noodles, wait 20 minutes, turn off stove and drain the noodles, put on a plate, add sauce on top, and serve'),
(2, 'Baked feta pasta', '2 pt grape tomatoes, ½ cup olive oil, 1 block feta, kosher salt, 10oz pasta, basil, pinch crushed red pepper flakes', '10.00', 'Preheat oven to 400 degrees. Put tomatoes, feta, pepper flakes, oil, and salt in large baking dish. Bake for 40 to 45 minutes. Meanwhile in a large pot of boiling water cook pasta until al dente. Take out the baking dish, pour content into glass bowl, sti'),
(3, 'Brownies', '½ cup butter, 1 cup white sugar, 2 eggs, 1 teaspoon vanilla extract, ⅓ cup unsweetened cocoa powder, ½ cup all-purpose flour, ¼ teaspoon salt, ¼ teaspoon baking powder', '16.00', 'Preheat oven to 350 degrees F (175 degrees C). Grease and flour an 8-inch square pan. In a large saucepan, melt 1/2 cup butter. Remove from heat, and stir in sugar, eggs, and 1 teaspoon vanilla. Beat in 1/3 cup cocoa, 1/2 cup flour, salt, and baking powde'),
(4, 'Vegan chickpea quinoa arugula salad', 'Quinoa, arugula, chickpeas, pea shoots, mini peppers, cherry tomatoes, snap peas, pepitas, avocado', '8.50', 'Add roasted chickpeas to oven, cook the quinoa, and meanwhile chop the vegetables. Then mix all ingredients with lemon garlic dressing and add the sliced avocado on top.'),
(5, 'Salmon patties', '1 15oz can salmon, 2 scallions, 1 tbsp. Chopped fresh drill, ½ cup panko breadcrumbs, ¼ cup mayo, 1 tbsp. Lemon juice, 1 tbsp dijon mustard, 1 large egg, kosher salt, black pepper, 2 tbsp extra virgin olive oil, baby spinach', '9.50', 'Add first 8 ingredients into large bowl, mix with salt and pepper. Form mix into 5 evenly-sized patties and heat oil in a large pan over medium heat. Cook patties until golden and crispy, 3-4 minutes per side, and then drain. Serve over spinach with lemon'),
(6, 'Egg Salad', '8 eggs, ½ cup mayonnaise, 1 teaspoon prepared yellow mustard, ¼ cup chopped green onion, salt and pepper to taste, ¼ teaspoon paprika', '9.99', 'Place egg in a saucepan and cover with cold water. Bring water to a boil and immediately remove from heat. Cover and let eggs stand in hot water for 10 to 12 minutes. Remove from hot water, cool, peel, and chop. Place the chopped eggs in a bowl, and stir '),
(7, 'Omelet', '2 large eggs, Kosher salt, Freshly ground black pepper, Pinch red pepper flakes, 2 tbsp. butter, 1/4 cup shredded cheddar, 2 tbsp. freshly chopped chives', '3.99', 'In a medium bowl, beat eggs until no whites remain, then season with salt, pepper, and a pinch red pepper flakes. In a medium non-stick skillet over medium heat, melt butter. Pour in eggs and tilt pan so eggs fully cover the entire pan. As eggs start to s'),
(8, 'Vanilla Milkshake', '4 large scoops (about 1 1/2 cup) vanilla ice cream, 1/4 cup milk, Whipped topping for garnish, Sprinkles for garnish, Maraschino cherry for garnish', '6.99', 'In a blender, blend together ice cream and milk. Pour into a glass and garnish with whipped topping, sprinkles, and a cherry.'),
(9, 'Air Fryer Hot Dogs', '4 hot dog buns, 4 hot dogs', '7.99', 'Preheat an air fryer to 400 degrees F (200 degrees C). Place buns in a single layer in the air fryer basket; cook in the preheated air fryer until crisp, about 2 minutes. Remove buns to a plate. Place hot dogs in a single layer in the air fryer basket; co'),
(10, 'Edible Cookie Dough', '¾ cup packed brown sugar, ½ cup butter, 1 teaspoon vanilla extract, ½ teaspoon salt, 1 cup all-purpose flour, 2 tablespoons milk, ½ cup milk chocolate chips, ½ cup mini chocolate chips', '11.59', 'Combine brown sugar and butter in a large bowl; beat with an electric mixer until creamy. Beat in vanilla extract and salt. Add flour; mix until a crumbly dough forms. Mix in milk. Fold in milk chocolate chips and mini chocolate chips.'),
(11, 'Simple Macaroni and Cheese', '1 (8 ounce) box elbow macaroni, ¼ cup butter, ¼ cup all-purpose flour, ½ teaspoon salt, ground black pepper to taste, 2 cups milk, 2 cups shredded Cheddar cheese', '15.69', 'Bring a large pot of lightly salted water to a boil. Cook elbow macaroni in the boiling water, stirring occasionally until cooked through but firm to the bite, 8 minutes. At the same time, melt butter in a saucepan over medium heat. Add flour, salt, and p'),
(12, 'Dumplings', '1 cup all-purpose flour, 2 teaspoons baking powder, 1 teaspoon white sugar, ½ teaspoon salt, 1 tablespoon margarine, ½ cup milk', '10.79', 'Stir together flour, baking powder, sugar, and salt in a bowl. Cut in butter until mixture is crumbly. Stir in milk and mix until a batter forms that is thick enough to be scooped with a spoon. Allow batter to rest for 3 to 5 minutes. Drop batter by spoon'),
(13, 'Beef Stir-Fry', '2 tablespoons vegetable oil, 1 pound beef sirloin, cut into 2-inch strips, 1 ½ cups fresh broccoli florets, 1 red bell pepper, cut into matchsticks, 2 carrots, thinly sliced, 1 green onion, chopped, 1 teaspoon minced garlic, 2 tablespoons soy sauce, 2 tab', '20.05', 'Heat vegetable oil in a large wok or skillet over medium-high heat; cook and stir beef until browned, 3 to 4 minutes. Move beef to the side of the wok and add broccoli, bell pepper, carrots, green onion, and garlic to the center of the wok. Cook and stir '),
(14, 'Grilled Cheese Sandwich', '4 slices white bread, 3 tablespoons butter, divided, 2 slices Cheddar cheese', '6.99', 'Preheat skillet over medium heat. Generously butter one side of a slice of bread. Place bread butter-side-down onto the skillet bottom and add 1 slice of cheese. Butter a second slice of bread on one side and place butter-side-up on top of the sandwich. G'),
(15, 'Reuben Sandwich', '8 slices rye bread, ½ cup Thousand Island dressing, 8 slices Swiss cheese, 8 slices deli sliced corned beef, 1 cup sauerkraut, drained, 2 tablespoons butter, softened', '15.99', 'Preheat a large griddle or skillet over medium heat. Spread one side of bread slices evenly with Thousand Island dressing. On four bread slices, layer one slice of Swiss cheese, 2 slices of corned beef, 1/4 cup sauerkraut, and a second slice of Swiss chee'),
(16, 'Baked Chicken Tenders', 'cooking spray, 1 large egg, beaten, 1 ¼ cups panko bread crumbs, 2 teaspoons garlic powder, 1 teaspoon onion powder, 1 teaspoon ground paprika, 1 teaspoon kosher salt, 1 teaspoon ground black pepper, 4 skinless, boneless chicken tenders, cut into 1/2-inch', '8.99', 'Preheat the oven to 450 degrees F (230 degrees C). Line a baking sheet with aluminum foil and spray with cooking spray. Place egg in a shallow dish. Place panko, garlic powder, onion powder, paprika, salt, and pepper into a large zip-top freezer bag and m'),
(17, 'Broccoli Chicken Divan', '1 pound chopped fresh broccoli, 1 ½ cups cubed, cooked chicken meat, 1 (10.5 ounce) can condensed cream of broccoli soup, ⅓ cup milk, ½ cup shredded Cheddar cheese, 2 tablespoons dried bread crumbs, 1 tablespoon butter, melted', '12.39', 'Preheat the oven to 450 degrees F (230 degrees C). Place broccoli in a saucepan with enough water to cover. Bring to a boil and cook until tender, about 5 minutes. Drain. Transfer cooked broccoli to a 9-inch pie plate. Scatter chicken over top. Mix conden'),
(18, 'Heavenly Halibut', '½ cup grated Parmesan cheese, ¼ cup butter, softened, 3 tablespoons mayonnaise, 3 tablespoons chopped green onions, 2 tablespoons lemon juice, ¼ teaspoon salt, 1 dash hot pepper sauce, 2 pounds skinless halibut filets', '14.32', 'Set an oven rack about 6 inches from the heat source and preheat the oven\'s broiler. Grease a baking dish; place halibut filets in the dish. Broil in the preheated oven until fish flakes easily with a fork, about 8 minutes. Meanwhile, mix Parmesan cheese,'),
(19, 'Sweet and Spicy Chicken', '3 tablespoons taco seasoning, 1 pound boneless skinless chicken breasts, cut into 1/2-inch cubes, 1 to 2 tablespoons canola oil, 1-2/3 cups chunky salsa, 1/2 cup peach preserves, Hot cooked rice', '27.22', 'Place taco seasoning in a large shallow dish; add chicken and stir to coat. In a large skillet, brown chicken in oil until no longer pink. Combine salsa and preserves; stir into skillet. Bring to a boil. Reduce heat; cover and simmer for 2-3 minutes or un'),
(20, 'Aperol Margaritas', '¾ cup orange juice, ¾ cup pink grapefruit juice, 2 ounces Aperol, 2 ounces tequila, 1 ½ ounces orange juice, 1 ounce pink grapefruit juice, Juice of one lime, Orange or grapefruit slices, mint, and squeeze of lime juice for garnish', '10.95', 'Make the juice ice cubes. Fill half of an empty ice cube tray with orange juice and the other half with pink grapefruit juice. Freeze completely. Once frozen, add the juice ice cubes and remaining ingredients to a blender. Blend until smooth. Pour into gl');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_pictures`
--

CREATE TABLE `recipe_pictures` (
  `recipe_id` int(11) NOT NULL,
  `picture` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipe_pictures`
--

INSERT INTO `recipe_pictures` (`recipe_id`, `picture`) VALUES
(1, 0x6e6f6f646c652e6a7067),
(2, 0x666574615f70617374612e6a7067),
(3, 0x62726f776e6965732e6a7067),
(4, 0x766567616e5f7175696e6f615f73616c61642e6a7067),
(5, 0x73616c6d6f6e5f706174746965732e6a7067),
(6, 0x6567675f73616c61642e6a7067),
(7, 0x6f6d656c65742e6a7067),
(8, 0x76616e696c6c615f6d696c6b7368616b652e6a7067),
(9, 0x686f745f646f672e6a7067),
(10, 0x636f6f6b69655f646f7567682e6a7067),
(11, 0x6d61635f616e645f6368656573652e6a7067),
(12, 0x64756d706c696e672e6a7067),
(13, 0x626565665f737469725f6672792e6a7067),
(14, 0x6772696c6c65646368656573655f73616e64776963682e6a7067),
(15, 0x72657562656e5f73616e64776963682e6a7067),
(16, 0x62616b65645f74656e646572732e6a7067),
(17, 0x636869636b656e5f646976616e2e6a7067),
(18, 0x68616c696275742e6a7067),
(19, 0x737765657473706963792e6a7067),
(20, 0x617065726f6c5f6d6172676172697461732e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_tags`
--

CREATE TABLE `recipe_tags` (
  `recipe_id` int(11) NOT NULL,
  `tag` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipe_tags`
--

INSERT INTO `recipe_tags` (`recipe_id`, `tag`) VALUES
(1, 'Cheap'),
(1, 'Quick'),
(2, 'Healthy'),
(2, 'Spicy'),
(3, 'Dessert'),
(4, 'Quick'),
(4, 'Vegan'),
(5, 'Healthy'),
(7, 'Cheap'),
(7, 'Quick'),
(8, 'Dessert'),
(8, 'Quick'),
(9, 'Quick'),
(10, 'Dessert'),
(10, 'Quick'),
(11, 'Comfort Food'),
(12, 'Cheap'),
(12, 'Vegetarian'),
(13, 'Healthy'),
(13, 'Quick'),
(14, 'Cheap'),
(14, 'Quick'),
(15, 'Fancy'),
(16, 'Comfort Food'),
(17, 'Healthy'),
(18, 'Fancy'),
(18, 'Healthy'),
(18, 'Quick'),
(19, 'Quick'),
(19, 'Spicy'),
(20, 'Dessert');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`user_id`, `recipe_id`) VALUES
(1, 1),
(2, 2),
(2, 3),
(4, 4),
(5, 5),
(6, 6),
(6, 7),
(6, 8),
(6, 9),
(7, 10),
(7, 11),
(8, 12),
(8, 13),
(8, 14),
(9, 15),
(9, 16),
(9, 17),
(10, 18),
(10, 19),
(10, 20);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `username`, `password`) VALUES
(1, 'Cool', 'Dude', 'admin', 'themostsecurepasswordever'),
(2, 'Bob', 'Bobson', 'bobert', 'bobbin'),
(3, 'Jane', 'Doe', 'janedd', 'commonpassword'),
(4, 'John', 'Doe', 'johndd', 'anothercommonpassword'),
(5, 'Sheldon', 'Cooper', 'shelly', 'grandma’scookierecipe'),
(6, 'Emma', 'Lee', 'emmmma', 'emmaemma613!'),
(7, 'Red', 'John', 'doctorr', 'guesswhoami'),
(8, 'Patrick', 'Jane', 'pjpsych', 'thementalist'),
(9, 'Michael', 'Scott', 'mscott', 'dundermifflin'),
(10, 'Dwight', 'Schrute', 'thisisrobot', 'youwillneverknowmypassword');

-- --------------------------------------------------------

--
-- Table structure for table `user_comments`
--

CREATE TABLE `user_comments` (
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `comment_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_comments`
--

INSERT INTO `user_comments` (`user_id`, `recipe_id`, `comment_number`) VALUES
(1, 2, 3),
(2, 1, 1),
(2, 1, 2),
(4, 3, 4),
(5, 4, 5),
(6, 5, 6),
(6, 10, 7),
(7, 15, 8),
(8, 19, 9),
(10, 20, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board_message`
--
ALTER TABLE `board_message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `board_pictures`
--
ALTER TABLE `board_pictures`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`recipe_id`,`comment_number`),
  ADD KEY `comment_number` (`comment_number`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`recipe_id`,`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`user_id`,`message_id`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`recipe_id`);

--
-- Indexes for table `recipe_pictures`
--
ALTER TABLE `recipe_pictures`
  ADD PRIMARY KEY (`recipe_id`);

--
-- Indexes for table `recipe_tags`
--
ALTER TABLE `recipe_tags`
  ADD PRIMARY KEY (`recipe_id`,`tag`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`user_id`,`recipe_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_comments`
--
ALTER TABLE `user_comments`
  ADD PRIMARY KEY (`user_id`,`recipe_id`,`comment_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `board_message`
--
ALTER TABLE `board_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
