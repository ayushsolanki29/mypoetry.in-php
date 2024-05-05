<?php
session_start();
include "auth/config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'pages/meta.html' ?>
    <title>Developer | MyPoetry.in</title>
    <meta name="title" content="Developer| MyPoetry.in">
    <meta name="description"
        content="Discover the reasons to choose MyPoetry.in for your poetic journey. Explore unique features, a supportive community, and exciting opportunities to showcase your verses.">
    <meta name="keywords"
        content="Why Choose Us, MyPoetry.in, Poetry Platform, Unique Features, Supportive Community, Poetry Opportunities, Showcase Verses">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/developer.php">
    <meta property="og:title" content="Developer| MyPoetry.in">
    <meta property="og:description"
        content="Discover the reasons to choose MyPoetry.in for your poetic journey. Explore unique features, a supportive community, and exciting opportunities to showcase your verses.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/developer.php">
    <meta property="twitter:title" content="Developer| MyPoetry.in">
    <meta property="twitter:description"
        content="Discover the reasons to choose MyPoetry.in for your poetic journey. Explore unique features, a supportive community, and exciting opportunities to showcase your verses.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">
    <link rel="stylesheet" href="styles/pricing.css">
    <link rel="canonical" href="https://mypoetry.in/developer.php">

    <?php include 'pages/links.html'; ?>

    <style>
        .intro-text {
            font-size: 18px;
            line-height: 1.6;
            text-align: justify;
        }

        .intro-highlight {
            font-weight: bold;
            color: #007bff;
            /* Bootstrap primary color */
        }
    </style>
</head>

<body class="sub_page">
    <div class="hero_area">
        <div class="bg-box">
            <img src="source/Images/hero-bg.jpg" alt="navabr">
        </div>
        <?php include 'pages/navbar.html' ?>
    </div>
    <div class="container">
        <section class="landing-page-section">
            <h2>Developer of <span class="gradient-text">mypoetry.in</span></h2>
        </section>
        <!-- Introduction Container -->
        <div class="intro-container">
            <!-- Introduction Text -->
            <p class="intro-text">
                Welcome to the Developer Page of Mypoetry.in! This page serves as a gateway to the behind-the-scenes
                magic that brings Mypoetry.in to life.
            </p>

            <p class="intro-text">
                Our development team at Dream Creations, led by <span class="intro-highlight">Team Dream Creations</span>, a
                seasoned full-stack developers,
                is dedicated to crafting a platform that celebrates the beauty of poetry and creative expression.
            </p>

            <p class="intro-text">
                Here, you'll find details about the technology stack powering Mypoetry.in, the dependencies we rely on,
                and meet the brilliant minds
                behind the code. Whether you're a poetry enthusiast or a fellow developer, we invite you to explore the
                intricacies of our work and
                discover the art and passion that drive Mypoetry.in.
            </p>
        </div>

        <h1 class="display-5 mt-5 mb-4">Discover mypoetry.in</h1>

        <div class="accordion mb-4" id="accordionExample">
            <div class="card">
                <div class="card-header bg-secondary" id="headingOne">
                    <h2 class="mb-0 text-light">
                        <button class="btn btn-block text-left" type="button" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            What is mypoetry.in?
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                    data-parent="#accordionExample">
                    <div class="card-body">
                        <p>Mypoetry.in is a unique platform dedicated to the art of poetry, offering a distinctive blend
                            of creativity, expression, and community engagement. At its core, mypoetry.in serves as an
                            online marketplace where poets can showcase and sell their personalized poetry, catering to
                            a diverse audience seeking unique and heartfelt verses.</p>

                        <p>Key Features:</p>
                        <ul>
                            <li><strong>Poetry Marketplace:</strong> Mypoetry.in provides poets with a dedicated space
                                to showcase and sell their crafted verses. Whether you're an aspiring poet or an
                                established wordsmith, the platform welcomes a wide range of poetic expressions.</li>

                            <li><strong>Free Tournaments:</strong> In addition to the marketplace, mypoetry.in hosts
                                regular poetry tournaments, offering a unique opportunity for poets to participate,
                                compete, and gain recognition. These tournaments are open to all, fostering a vibrant
                                community of creative minds.</li>

                            <li><strong>Extensive Categories:</strong> Mypoetry.in boasts an extensive collection of
                                poetry across various categories. From love and emotions to nature and inspiration, the
                                platform curates a diverse range of poetic genres, ensuring there's something for every
                                reader.</li>
                        </ul>

                        <p>Whether you're a poetry enthusiast looking to explore new verses or a poet eager to share
                            your creations with the world, mypoetry.in invites you to immerse yourself in the beauty of
                            words, emotions, and artistic expression.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-secondary" id="headingTwo">
                    <h2 class="mb-0 text-light">
                        <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Which Dependency is Used?
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <p>At mypoetry.in, we leverage a set of technologies and dependencies to ensure a seamless and
                            feature-rich user experience. Below is a list of key technologies and dependencies used in
                            the development of the platform:</p>

                        <h5>Technology List:</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Technology</th>
                                    <th>Version</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Bootstrap</td>
                                    <td>Latest version</td>
                                </tr>
                                <tr>
                                    <td>PHP</td>
                                    <td>Latest version</td>
                                </tr>
                                <tr>
                                    <td>MySqli</td>
                                    <td>Latest version</td>
                                </tr>
                                <tr>
                                    <td>jQuery</td>
                                    <td>Latest version</td>
                                </tr>
                                <tr>
                                    <td>cdnjs</td>
                                    <td>Latest version</td>
                                </tr>
                                <tr>
                                    <td>Cloudflare</td>
                                    <td>Latest version</td>
                                </tr>
                                <tr>
                                    <td>Font Awesome</td>
                                    <td>Latest version</td>
                                </tr>
                                <tr>
                                    <td>HTTP/3</td>
                                    <td>Latest version</td>
                                </tr>
                                <!-- Add other technologies and versions as needed -->
                            </tbody>
                        </table>

                        <p>These software libraries and coding dependencies contribute to the robustness, performance,
                            and visual appeal of mypoetry.in. We keep our technology stack updated to provide users with
                            the latest features and ensure a modern and enjoyable browsing experience.</p>

                        <p>If you have any specific questions about our technology stack or would like more details on a
                            particular dependency, feel free to reach out to our development team.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-secondary " id="headingThree">
                    <h2 class="mb-0 text-light">
                        <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Who is the Developer?
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        <p>Mypoetry.in is the brainchild of Dream Creations, a dedicated team of developers passionate
                            about crafting unique and innovative solutions. Our main developer, Ayush Solanki, is a
                            seasoned full-stack developer with a wealth of experience in creating dynamic and
                            user-friendly web applications.</p>

                        <p><strong>Developer 1:</strong></p>
                        <ul>
                            <li><strong>Name:</strong> Ayush Solanki</li>
                            <li><strong>Role:</strong> Full Stack Developer</li>
                            <li><strong>Expertise:</strong> Ayush brings a comprehensive skill set, covering both
                                front-end and back-end development. His proficiency in technologies such as HTML, CSS,
                                JavaScript, PHP, and more, contributes to the robust architecture and functionality of
                                mypoetry.in.</li>
                        </ul>

                        <p><strong>Developer 2:</strong></p>
                        <ul>
                            <li><strong>Name:</strong> Priyanshu Vaghela</li>
                            <li><strong>Role:</strong> Full-stack Developer</li>
                            <li><strong>Contribution:</strong> Priyanshu, as a Developer, actively contributes to
                                the development process, bringing fresh ideas and enthusiasm to the team.</li>
                        </ul>

                        <p>The Dream Creations team is committed to delivering a seamless and enjoyable experience for
                            users of mypoetry.in. If you have any feedback, suggestions, or inquiries, feel free to
                            reach out to our development team. We value your input and strive to make mypoetry.in a
                            platform that truly resonates with poetry enthusiasts and creators alike.</p>
                    </div>
                </div>
            </div>

        </div>
        <h1 class="mt-5 mb-4">Connect with Developer</h1>

        <form action="https://formspree.io/f/xvonlzrw" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Your Name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Your Email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" rows="3" placeholder="Your Message" name="msg"
                    required></textarea>
            </div> 
            <button type="submit" class="btn btn-primary mb-3">Submit</button>

            <p>Feel free to reach out to <span class="intro-highlight" title="Dream Creation Developers"> Our Team </span> with any questions,
                concerns,
                or project inquiries you may have.</p>
            <ul class="list-unstyled social">
                <li><i class="bi bi-geo-alt"></i> Address: Ahemdabad, Gujarat, INDIA</li>

                <li> <i class="bi bi-envelope"></i> Email: <a
                        href="mailto:dreamcreations.help@gmail.com">dreamcreations.help@gmail.com</a> </li>
            </ul>
        </form>



    </div>
    <?php include 'pages/footer.html'; ?>
    <?php include 'pages/scripts.html'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>