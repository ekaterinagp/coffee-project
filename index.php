<?php 
$sTitle = ' | Front page';
$sCurrentPage = 'frontpage';
require_once(__DIR__.'/components/header.php');
?>

<main class="frontpage">

<section class="section-one grid grid-almost-two mb-large">
    <div class="grid container-header align-items-center p-large">
        <div class="logo bg-contain align-self-bottom mb-small"><h1>Welcome</h1></div>
        <p class="align-self-top mt-small mb-medium">
        Enhance your everyday coffee experience with a coffee subscription tailored to your taste or discover a world of coffee and let us surprise you!
        </p>
        <a href="subscribe.php" class="button">Subscribe</a>
    </div>
    <div class="grid grid-two container masonry">
        <div class="grid image-container bg-light-brown">
            <div class="image bg-contain img1"></div>
        </div>
        <div class="grid image-container bg-brown">
            <div class="image bg-contain img2"></div>  
        </div>
        <div class="grid image-container bg-medium-light-brown">
            <div class="image bg-contain img3"></div>
        </div>
        <div class="grid image-container bg-dark-brown">
            <div class="image bg-contain img4"></div>
        </div>
    </div>
    
</section>

<section class="section-two grid mb-large">
    <h2>What you get</h2>
    <h3>We make sure you get the best you wished for and more </h3>
    <div class="grid grid-two-thirds-reversed container ph-xlarge"> 
        <div class="image bg-contain"></div>
        <div class="list grid align-items-center">
            <ul>
                <li>
                    <h5>Coffee</h5>
                    <p>YOUR HANDPICKED SELECTION OF QUALITY COFFEE</p>
                </li>
                <li>
                    <h5>Tips</h5>
                    <p>TASTING NOTES AND BREWING TIPS</p>
                </li>
                <li>
                    <h5>Experience</h5>
                    <p>COFFEE TAILORMADE TO YOUR TASTE - EVERYDAY SINGLE DAY</p>
                </li>
            </ul>
            <a href="subscribe.php" class="button">Subscribe</a>
        </div>
    </div>
</section>

<section class="section-three grid mb-large">
    <h2>How it works</h2>
    <h3>We make sure our customers meet their best expectations</h3>
    <div class="grid grid-three container"> 
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
        <div class="step two bg-medium-light-brown">
            <div class="step-no absolute">
                <h4 class="color-white relative">Step</h4>
                <div class="no relative">2</div>
            </div>
            <div class="image bg-contain"></div>
            <div class="description">
                <h5 class="color-white">Choose amount you need and delivery method </h5>
            </div>
        </div>
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
    </div>
    <a href="subscribe.php" class="button margin-auto mt-medium">Subscribe</a>
</section>

<section class="section-four grid mb-xlarge">
    <h2>Why choose The Proper Pour</h2>
    <h3>We make sure our customers meet their best expectations</h3>
    <div class="grid grid-three container ph-xlarge"> 
        <div class="list one">
            <ul>
                <li>
                    <h5>No binding</h5>
                    <p>You can stop your subscription anytime</p>
                </li>
                <li>
                    <h5>Tailormade taste</h5>
                    <p>Take our test and get matched with the perfect coffee based on your taste</p>
                </li>
            </ul>
        </div>

        <div class="image bg-contain relative"></div>

        <div class="list one">
            <ul>
                <li>
                    <h5>Coffee discount</h5>
                    <p>Our subscribers have 10% discount for all coffee in our webshop</p>
                </li>
                <li>
                    <h5>Free delivery</h5>
                    <p>Delivery is always included in the price</p>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="section-five grid mb-large">
    <h2>Enhance your experience</h2>
    <h3>Tips and tricks to make your best cup of coffee</h3>
    <div class="grid grid-four container masonry"> 
            <a href="#" class="item one bg-dark-brown">
                    <div class="image bg-contain"></div>
                    <h5 class="color-white ph-medium relative">How to choose coffee</h5>
            </a>
       
        <a href="#" class="item two bg-light-brown">
                <div class="image bg-contain"></div>
                <h5 class="color-white ph-medium relative">How to brew coffee</h5>
        </a>
        <a href="#" class="item three bg-brown">
                <div class="image bg-contain"></div>
                <h5 class="color-white ph-medium relative">Christmas coffee</h5>
        </a>
        <a href="#" class="item four bg-light-brown">
                <div class="image bg-contain relative"></div>
                <h5 class="color-white ph-medium relative">Types of coffee you can make at home</h5>
        </a>
        <a href="#" class="item five bg-medium-light-brown">
                <div class="image bg-contain"></div>
                <h5 class="color-white ph-medium relative">Best coffee equipment</h5>
        </a>
        <a href="#" class="item six bg-medium-light-brown">
                <div class="image bg-contain"></div>
                <h5 class="color-white ph-medium relative">Sustainability in coffee drinking</h5>
        </a>
        
    </div>
</section>

</main>

<?php
$sScriptPath = 'script.js';
require_once(__DIR__.'/components/footer.php');