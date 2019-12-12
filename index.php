<?php
$sTitle = ' | Front page';
$sCurrentPage = 'frontpage';
require_once(__DIR__ . '/components/header.php');
?>

<main class="frontpage">

    <section class="section-one grid grid-almost-two mb-large">
        <div class="align-items-center pl-xlarge relative">
            <div class="banner-text-container absolute">
            <div class="logo">
                <h1>Welcome</h1>
            </div>
            <h2 class="banner-message align-self-top pt-small pb-medium pr-large">
                Enhance your everyday coffee experience with a coffee subscription tailored to your taste or discover a world of coffee and let us surprise you!
            </h2>
            
            <a href="subscribe">
                <button= class="button">Subscribe </button>
            </a>
            </div>
        </div>
        <div class="gridForAboveTheFold">
            <div class=" image-container bg-light-brown box1">
                <div class="image bg-contain img1"></div>
            </div>
            <div class=" image-container bg-brown box2">
                <div class="image bg-contain img2"></div>
            </div>
            <div class=" image-container bg-medium-light-brown box3">
                <div class="image bg-contain img3"></div>
            </div>
            <div class=" image-container bg-dark-brown box4">
                <div class="image bg-contain img4"></div>
            </div>
        </div>
    </section>

    <section class="section-two grid mb-large">
        <h2 class="mb-small">What you get</h2>
        <h3 class="">We make sure you get everything you wish for and more </h3>
        <div class="grid grid-two-thirds-reversed container ph-xlarge">
            <div class="image bg-contain"></div>
            <div class="bg-brown colorBlock">

                <div class="list p-medium">
                    <div>
                        <h4 class="color-white">COFFEE</h4>
                        <p>Your handpick selection of coffee</p>
                    </div>
                    <div>
                        <h4 class="color-white">TIPS</h4>
                        <p>Tasting notes and brewering tips</p>
                    </div>
                    <div>
                        <h4 class="color-white">EXPERIENCE</h4>
                        <p>Coffee tailormade to your taste everyday</p>
                    </div>
                    <a href="subscribe" class="button">Subscribe</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-three grid mb-large">
        <h2 class="mb-small">How it works</h2>
        <h3 class="">Enhancing your everyday coffee experience has never been easier</h3>
        <div class="grid grid-three container">
            <div class="flipcontainer  one grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="step one bg-light-brown">
                        <div class="step-no absolute">
                            <h4 class="color-white relative">Step</h4>
                            <div class="no relative">1</div>
                        </div>
                        <div class="image bg-contain"></div>
                        <div class="description">

                            <h5 class="color-white">Select a coffee you like or take a test to get an advice from us</h5>
                        </div>
                    </div>
                    <div class="back p-medium">

                        <h5>We have 6 types of subscription</h5>

                        <p>To make sure our subscriptions fit to the different taste of our clients, we generated 6 different subscriptions. You can choose one, but if you still in doubt, go a head and take a test we created, which will provide tailored recommendations</p>

                    </div>
                </div>
            </div>
            <div class="flipcontainer  one grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="step two bg-medium-light-brown">
                        <div class="step-no absolute">
                            <h4 class="color-white relative">Step</h4>
                            <div class="no relative">2</div>
                        </div>
                        <div class="image bg-contain"></div>
                        <div class="description">
                            <h5 class="color-white">Create a user profile and choose a delivery method</h5>
                        </div>
                    </div>
                    <div class="back p-medium">
                        <h5>Create a user profile and get a discount</h5>
                        <p>We take our users sensitive data very seriously, that is why we highly recommend you to create a profile and we will protect your data. Also as a new user you get a discount from us as a welcome gift! </p>
                    </div>
                </div>
            </div>
            <div class="flipcontainer  one grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="step three bg-dark-brown">
                        <div class="step-no absolute">
                            <h4 class="color-white relative">Step</h4>
                            <div class="no relative">3</div>
                        </div>
                        <div class="image bg-contain"></div>
                        <div class="description">
                            <h5 class="color-white">Get it delivered and enjoy your coffee!</h5>
                        </div>
                    </div>
                    <div class="back p-medium">
                        <strong>
                            <h3>We deliver as fast as we can</h3>
                        </strong>
                        <p>We aim to deliver your coffee as soon as possible and the most convineient way. We know how important to get a freshly roasted coffee, that is why we work hard to make your coffee drinking experience as best as possible. </p>
                    </div>
                </div>
            </div>
        </div>
        <a href="subscribe" class="button margin-auto mt-medium">SUBSCRIBE</a>
    </section>

    <section class="section-four grid mb-large">
        <h2 class="mb-small">Why choose The Proper Pour</h2>
        <h3 class="alignTextCenter ">Get ready to have all your expectations met</h3>
        <div class="grid grid-two container ph-xlarge">
            <div class="colorBlock1 bg-medium-light-brown">
                <div class="list1 list p-medium">
                    <div>
                        <h4 class="color-white">No binding</h4>
                        <p>You can stop your subscription anytime</p>
                    </div>
                    <div>
                        <h4 class="color-white">Tailormade taste</h4>
                        <p>Designed test helps you to choose the right coffee for you</p>
                    </div>
                    <div>
                        <h4 class="color-white">Coffee discount</h4>
                        <p>Our subscribers have 10% discount for all coffee in our webshop</p>
                    </div>
                    <div>
                        <h4 class="color-white">Free delivery</h4>
                        <p>Delivery is always included in the price</p>
                        <a href="subscribe"><button class="button margin-auto mt-large" id="btnInside">SUBSCRIBE </button></a>
                    </div>

                </div>
            </div>
            <div class="image bg-contain relative cupImage"></div>


        </div>

    </section>

    <section class="section-five grid mb-large">
        <h2 class="mb-small">Enhance your experience</h2>
        <h3>Tips and tricks to make your best cup of coffee</h3>
        <div class="grid grid-four container masonry">
            <div class="flipcontainer item one grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-dark-brown">
                        <div class="image bg-contain"></div>
                        <h4 class="color-white relative text-center positionOnFlipper">How to choose coffee</h4>
                    </div>
                    <div class="back p-medium ">


                        <p class="p-smallest"> If you prefer<strong> coffee with a smooth taste </strong>, then look for dry, light coloured coffee beans, which are roasted for a shorter time.
                            If you like a strong, bold cofee, buy beans,that roasted longer.

                        </p>
                        <p class="p-smallest"><strong>Light roasted coffee beans contain the highest level of caffeine </strong>, then medium and then dark roasted. If you are looking for increase your caffeine intake, you are better going for light or medium roasted beans. </p>
                        <p class="p-smallest">Freshness is important, so <strong>check the roast date </strong> the label before buying coffee! If you don’t have a coffee grinder in your house, go for the whole bean bag and ask the supermarket or café to grind them for you.</p>

                    </div>
                </div>
            </div>

            <div class="flipcontainer item two grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-for-how">
                        <div class="image bg-contain"></div>
                        <h4 class="color-white  relative positionOnFlipper">How to brew coffee</h4>
                    </div>
                    <div class="back p-medium">
                        <p class="p-smallest">Make sure that <strong>your tools are cleaned and rinsed </strong> hot water. It’s important to check that no grounds have been left to collect and that there’s no build-up of coffee, which can make future cups of coffee taste bitter and rancid.</p>
                        <p class="p-smallest"><strong>Great coffee starts with great beans </strong> the flavour of your coffee is not only determined by your favourite brewing process, but also by the type of coffee you select.</p>
                        <p class="p-smallest"> Buy coffee as soon as possible after it’s roasted. <strong>Fresh-roasted coffee is essential </strong> to a quality cup, so buy your coffee in small amounts (ideally every two weeks).</p>
                        <p class="p-smallest"><strong>The size of the grind is hugely important </strong> to the taste of your coffee. If your coffee tastes bitter, it may be over-extracted, or ground too fine. On the other hand, if your coffee tastes flat, it may be under-extracted, meaning your grind is too rough.</p>


                    </div>
                </div>
            </div>
            <div class="flipcontainer item three grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-medium-light-brown">
                        <div class="image bg-contain"></div>
                        <h4 class="color-white relative positionOnFlipper">Christmas coffee</h4>
                    </div>
                    <div class="back p-medium">
                        <p class="p-smallest">With Christmas around the corner, remember to add it also to your coffee!</p>
                        <p class="p-smallest"> What about some cinnamon, ground cardamom, cloves, nutmeg or whipped cream and marshmallows? <strong>Check out other recipes from our friends from BestRecipies.com/chrismasCoffee! </strong></p>
                    </div>
                </div>
            </div>
            <div class="flipcontainer item four grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-for-how">
                        <div class="image bg-contain relative"></div>
                        <h4 class="color-white  relative positionOnFlipper">4 Tips for Serving Good Coffee for a Crowd</h4>
                    </div>
                    <div class="back p-medium">
                        <p class="p-smallest"><strong>Buy good beans</strong>
                            Make sure your guests are happy about what they are drinking</p>
                        <p class="p-smallest"> <strong>Choose a method that works for a crowd</strong>
                            We recommend you buy a large French press, to be sure that you can serve many cups at a time.</p>
                        <p class="p-smallest"><strong>Keep it warm</strong>
                            We recommend you invest in a good thermos if you like long weekend brunches at your home.</p>
                        <p class="p-smallest"> <strong>Have the proper additions at hands</strong>
                            Be sure that milk, sugar and water are on the table!
                        </p>
                    </div>
                </div>
            </div>
            <div class="flipcontainer item five grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-medium-light-brown">
                        <div class="image bg-contain"></div>
                        <h4 class="color-white  relative positionOnFlipper">Best coffee equipment <br> Our choice in 2019</h4>
                    </div>
                    <div class="back p-medium">
                        <p class="p-smallest"> <strong>Home Coffee Grinder </strong> has easily adjustable grind settings, a solid burr set, good solid construction, and overall value for the money.</p>
                        <p class="p-smallest"> <strong>Automatic Brewer </strong>have been some of our favourites for years, mainly because they match great brewing performance with an affordable price.</p>
                        <p class="p-smallest"> <strong> Home Espresso Machine </strong> allows you to fully tweak how your shot pulls, so it is absolutely perfect for espresso nerds like us.</p>
                        <p class="p-smallest"> All these amazing equipment can be bought at our friends’ shop:<strong> friendsshop/shop</strong></p>
                    </div>
                </div>
            </div>

            <div class="flipcontainer item six grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-dark-brown">
                        <div class="image bg-contain"></div>
                        <h4 class="color-white relative positionOnFlipper">3 ways to be a more sustainable coffee drinker</h4>
                    </div>
                    <div class="back p-medium">
                        <p class="p-smallest">Look for <strong>brands that support of sustainable coffee producers and environment </strong>. (All our brands are sustainable!)</p>
                        <p class="p-smallest"> Disposable coffee cups, single-serve capsules and pods are bad for the environment. Try to <strong> avoid disposable, plastic and paper</strong> in your coffee making or at least go for recycled. Check our friends’ tools for coffee making in a sustainable way: <strong>linkToFriends/sustainable</strong></p>
                        <p class="p-smallest"> <strong>Coffee grounds are biodegradable </strong>, which means you can use them to fertilize your plants. If you do not have a garden, make a hair or skin mask!</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

<?php
// $sScriptPath = 'script.js';
require_once(__DIR__ . '/components/footer.php');
