<?php
session_start();
include "auth/config.php";

if (!isset($_COOKIE['aboutpage-view'])) {
    $name = "someone";
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $select = "SELECT `username` FROM `users` WHERE user_id=$userId ";
        $result = mysqli_query($con, $select);
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row["username"];
        }
    }

    $notiInstert = "INSERT INTO `notification`(`title`, `url`, `date`) VALUES ('$name Just Viewed Your Profile','index.php',NOW())";
    $result = mysqli_query($con, $notiInstert);
    if (!$result) {
        echo "Erorr";
    }

    setcookie('aboutpage-view', '1', time() + (10 * 24 * 60 * 60));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'pages/meta.html' ?>
    <title>About Satyam Arya - Founder of Mypoetry.in</title>
    <meta name="title" content="Satyam Arya - Poetry Writer and Founder of Mypoetry.in">
    <meta name="description"
        content="Learn more about Satyam Arya, a passionate poetry writer and the founder of Mypoetry.in. Explore the journey behind Mypoetry.in and the creative vision that drives Satyam's poetic expressions.">
    <meta name="keywords"
        content="Satyam Arya, Mypoetry.in founder, poetry writer, poetic journey, creative vision, poetry platform, about me, Mypoetry.in story">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mypoetry.in/about.php">
    <meta property="og:title" content="Satyam Arya - Poetry Writer and Founder of Mypoetry.in">
    <meta property="og:description"
        content="Learn more about Satyam Arya, a passionate poetry writer and the founder of Mypoetry.in. Explore the journey behind Mypoetry.in and the creative vision that drives Satyam's poetic expressions.">
    <meta property="og:image" content="https://mypoetry.in/source/og-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://mypoetry.in/about.php">
    <meta property="twitter:title" content="Satyam Arya - Poetry Writer and Founder of Mypoetry.in">
    <meta property="twitter:description"
        content="Learn more about Satyam Arya, a passionate poetry writer and the founder of Mypoetry.in. Explore the journey behind Mypoetry.in and the creative vision that drives Satyam's poetic expressions.">
    <meta property="twitter:image" content="https://mypoetry.in/source/og-image.png">

    <link rel="canonical" href="https://mypoetry.in/about.php">

    <?php include 'pages/links.html'; ?>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/swiper-bundle.min.css">
    <link rel="stylesheet" href="styles/about.css">
    <style>
        ::-webkit-scrollbar {
            display: none;
        }

        .modal-body li {
            list-style: none;
            color: #000 !important;
            padding: 0.5rem !important;

        }

        .scrolltotop-style {
            position: fixed;
            right: 4%;
            bottom: 8%;
            z-index: 99999999999999999999999999999999;

        }

        #scrolltop {
            width: 50px;
            height: 50px;
            background: #FFBE33;
            padding-top: 30%;
            color: #fff;
            border-radius: 50%;
            font-size: 20px;
        }

        .qualification__bg-container {
            position: relative;
            text-align: center;
        }

        .qualification__bg-container img {
            width: 700px;
            /* Adjust the width as needed */
            display: block;
            margin: 0 auto;
            filter: blur(1px);
        }

        .overlay-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .overlay-text h1 {
            font-size: 2.5rem;
            /* Adjust the font size as needed */
        }

        .overlay-text p {
            font-size: 1.25rem;
            /* Adjust the font size as needed */
        }

        @media (max-width: 430px) {
            .overlay-text h1 {
                font-size: 1.5rem;
                /* Adjust the font size as needed */
            }

            .overlay-text p {
                font-size: .75rem;
                /* Adjust the font size as needed */
            }
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
    <!--==================== HEADER ====================-->

    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== HOME ====================-->
        <section class="home section" id="home">
            <div class="home__container container grid section__border">
                <div class="home__data grid">
                    <h1 class="home__title">
                        Hi, I'm Satyam V.Arya<br>(Chaahat.k.Arya)<br>
                        Poetry Writter <br>

                    </h1>

                    <div class="home__blob grid">
                        <div class="home__perfil">
                            <img src="source/about/perfil.png" alt="Home Perfil">
                        </div>

                        <img src="source/about/shape-wawes.svg" alt="" class="home__shape-wawes">
                        <img src="source/about/shape-circle.svg" alt="" class="home__shape-circle">
                    </div>

                    <ul class="home__social">
                        <a href="https://instagram.com/mere_ahsaas2709?utm_source=qr&igshid=MzNlNGNkZWQ4Mg=="
                            target="_blank" class="home__social link">
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        <a href="https://www.facebook.com/shiv.arya.3517?mibextid=ZbWKwL" target="_blank"
                            class="home__social link">
                            <i class="fa-brands fa-facebook"></i>
                        </a>

                        <a href="mailto:admin@mypoetry.com" target="_blank" class="home__social link">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                    </ul>
                </div>

                <!--==================== HOME info 1 ====================-->

                <div class="home__info">

                    <div>
                        <h3 class="home__info-title">
                            Get to know me better
                        </h3>

                        <p class="hone__info-description">
                            "Hi there, I'm Satyam V.Arya<br>[Chaahat.k.Arya], a poetic soul hailing from the enchanting
                            city of Gandhinagar,
                            Gujarat. I'm deeply passionate about crafting exquisite poetry."
                        </p>
                    </div>

                    <div>
                        <h3 class="home__info-title">
                            CONTACT
                        </h3>

                        <p class="about__description">
                            <i class="fa-solid fa-location-dot"></i> Gandhinagar, Gujarat <br>
                            <i class="fa-solid fa-envelope"></i> satyoannpurna01@gmail.com <br>
                            <span onclick="contact_show()" style="cursor:pointer;" title="Click For Show Number"> <i
                                    class="fa-brands fa-whatsapp"></i> <span
                                    class="blur-phone">+911234567890</span></span>
                        </p>

                    </div>

                    <div>
                        <h3 class="home__info-title">
                            SERVICES
                        </h3>

                        <p class="about__description">
                            - Crafting Personalized Poetry 🖋️<br>
                            - Stories to Life through Books 📚<br>
                            - Poetry Creative Editing ✨<br>
                        </p>

                    </div>
                </div>

                <!--==================== HOME info 2 ====================-->
                <div class="home__info">
                    <div>
                        <h3 class="home__info--title">
                            YEARS OF EXPERIENCE
                        </h3>
                        <p class="home__info-number">
                            15+
                        </p>
                    </div>
                    <div>
                        <h3 class="home__info--title">
                            COMPLETED BOOKS
                        </h3>
                        <p class="home__info-number">
                            2+
                        </p>
                    </div>
                    <div>
                        <h3 class="home__info--title">
                            ANTHOLOGY
                        </h3>
                        <p class="home__info-number">
                            350+
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!--==================== SKILLS ====================-->


        <!--==================== QUALIFICATION ====================-->
        <section class="qualification section" id="qualification">
            <h2 class="section__title">My Poetry Journey</h2>
            <span class="section__subtitle">Experience & Insights</span>


            <div class="qualification__container container grid section__border">
                <!--==================== QUALIFICATION 1 ====================-->

                <div class="qualification__content">
                    <h3 class="qualification__title">
                        <i class="ri-quill-pen-line"></i> Experience
                    </h3>

                    <div class="qualification__info">
                        <div>
                            <h3 class="qualification__name">
                                Starting of Poetry
                            </h3>
                            <span class="qualification__country">Gandhinagar, Gujarat</span>
                            <span class="qualification__year">2013 - Present</span>
                        </div>

                    </div>
                    <div class="qualification__info">
                        <div>
                            <h3 class="qualification__name">
                                ANTHOLOGY
                            </h3>
                            <span class="qualification__country"> Poetry Anthology (3+) Contributions</span>
                            <span class="qualification__year">2017 - 2019</span>
                        </div>

                    </div>
                    <div class="qualification__info">
                        <div>
                            <h3 class="qualification__name">
                                District Level Competition
                            </h3>
                            <span class="qualification__country">Achieved Grade A</span>
                            <span class="qualification__year">2019 - 2022</span>
                        </div>

                    </div>

                </div>
                <!--==================== QUALIFICATION 2 ====================-->
                <div class="qualification__content">
                    <h3 class="qualification__title">
                        <i class="fas fa-lightbulb"></i> Insights
                    </h3>
                    <div class="qualification__info">
                        <div>
                            <h3 class="qualification__name">
                                Book Published (1)
                            </h3>
                            <span class="qualification__country">Title: Love Birds</span>
                            <span class="qualification__year">2021 - 2022</span>
                        </div>
                    </div>
                    <div class="qualification__info">
                        <div>
                            <h3 class="qualification__name">
                                Certificate
                            </h3>
                            <span class="qualification__country">Over 500+ Certificates Earned</span>
                            <span class="qualification__year">Throughout My Career</span>
                        </div>

                    </div>


                </div>

            </div>
            <img src="source/about/shape-circle.svg" alt="svg" class="qualification__img">
        </section>

        <section class="qualification section" id="qualification">
            <h2 class="section__title">Explore Our Gallery</h2>
            <p class="section__subtitle">Discover the Faces Behind Our Team</p>

            <a href="gallary.php" target="blank">
                <div class="qualification__container container d-flex section__border">
                    <div class="qualification__bg-container">
                        <img src="source/about/img.png" loading="lazy" alt="Gallery" class="img-fluid" />
                        <div class="overlay-text text-white">
                            <h1 class="text-white">Faces in Verse</h1>
                            <p>Discover the poetry and people who shape our creative community.</p>
                        </div>



                    </div>



            </a>
        </section>


        <!--==================== SERVICES ====================-->
        <section class="services section" id="services">
            <h2 class="section__title">Services</h2>
            <span class="section__subtitle">What I offer</span>

            <div class="services__container container grid section__border">
                <div class="services__card">
                    <i class="ri-quill-pen-line"></i> <!-- Replace with a suitable icon for Crafting Poetry -->

                    <h2 class="services__title">
                        Crafting Poetry
                    </h2>

                    <p class="services__description">
                        Let me weave words into beautiful verses for your emotions and thoughts.
                    </p>

                    <div class="services__border"></div>
                </div>

                <div class="services__card">
                    <i class="ri-book-2-line"></i>
                    <!-- Replace with a suitable icon for Stories to Life through Books -->

                    <h2 class="services__title">
                        Stories to Life through Books
                    </h2>

                    <p class="services__description">
                        Transform your stories and ideas into captivating books.
                    </p>

                    <div class="services__border"></div>
                </div>

                <div class="services__card">
                    <i class="ri-edit-2-line"></i> <!-- Replace with a suitable icon for Poetry Creative Editing -->

                    <h2 class="services__title">
                        Poetry Creative Editing
                    </h2>

                    <p class="services__description">
                        Enhance your poetry and give it the perfect touch of creativity.
                    </p>

                    <div class="services__border"></div>
                </div>
            </div>

        </section>

        <!--==================== PROJECTS ====================-->
        <section class="projects section " id="projects">
            <div class="section__title">My Works
                <span class="section__subtitle">Most recent work</span>

                <div class="container section__border">
                    <div class="projects__container swiper">
                        <div class="swiper-wrapper">

                            <!--==================== PROJECT 1 ====================-->
                            <div class="projects__content swiper-slide">
                                <img src="source\about\Lovebirds.jpg" alt="" class="projects__img" style="width:200px">

                                <div>
                                    <span class="projects__subtitle">My Book
                                    </span>
                                    <h1 class="projects__title">Love Birds</h1>

                                    <a href="https://amzn.eu/d/crVxDxv " class="projects__button">Buy Book<i
                                            class="ri-arrow-right-line"></i></a>
                                </div>
                            </div>
                            <!--==================== PROJECT 2 ====================-->
                            <div class="projects__content swiper-slide">
                                <img src="source\about\certificate1.jpg" alt="" class="projects__img"
                                    style="width:350px">

                                <div>
                                    <span class="projects__subtitle">My Certificate
                                    </span>
                                    <h1 class="projects__title">Writers Vibe</h1>

                                    <a href="source\about\certificate1.jpg" class="projects__button">View Certificate<i
                                            class="ri-arrow-right-line"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="container mt-5">
        <div class="container mt-5">
            <h2 class="text-success">A Heartfelt Thank You </h2>
            <p>Join us in expressing our deep gratitude to the exceptional individuals whose creative spirit has
                breathed life into MyPoetry.in.</p>
            <div class="swiper-container">
                <div class="swiper-wrapper" id="name-cards-container">
                </div>

            </div>
        </div>
        <button class="btn btn-success mb-2" data-toggle="modal" data-target="#personModal">View All Persons</button>

        <div class="modal fade" id="personModal" tabindex="-1" role="dialog" aria-labelledby="personModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" style="width:fit-content" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="personModalLabel">Special Thanks To</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="personList">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>

        </div>

    </div>



    <?php include 'pages/footer.html'; ?>
    <div class="scrolltotop-style">
        <center><i class="fa-solid fa-arrow-up fa-shake" id="scrolltop"></i></center>
    </div>
    <?php include 'pages/scripts.html'; ?>
    <script src="scripts/swiper-bundle.min.js"></script>
    <script src="scripts/about.js"></script>
</body>

<script>

const people = [
        { name: "Vinay Kumar Arya - Father", message: "Dad, your wisdom and guidance have shaped me into who I am today. Thank you for being my rock." },
        { name: "Vimla Ben V Arya - Mother", message: "Mom, your love and warmth make our home a haven. Thank you for your unwavering support and sacrifices." },
        { name: "Pritam. A. Arya", message: "Pritam, your enthusiasm and dedication to our projects are truly commendable. Thank you for your hard work." },
        // Add more people with their unique messages
        { name: "Minakshi P. Gadhavi", message: "Minakshi, your positive energy and hard work make a significant impact. Thank you for your contributions." },
        { name: "Developers [Priyanshu Vaghela And Ayush Solanki]", message: "Priyanshu and Ayush, your coding wizardry has brought our projects to life. Thank you for your technical brilliance." },
        { name: "Param Pujya Shri Aadrniy Janak Ben", message: "Janak Ben, your spiritual guidance lights our path. Thank you for your wisdom and teachings." },
        { name: "Ranjit R. Arya", message: "Ranjit, your commitment and hard work have not gone unnoticed. Thank you for your valuable contributions." },
        { name: "Anushka Singh [Pannchi]", message: "Anushka, your creativity and innovative ideas add a special touch to our projects. Thank you for your artistic flair." },
        { name: "Fenee Patel", message: "Fenee, your attention to detail and dedication are truly appreciated. Thank you for your hard work." },
        { name: "Simran Solanki", message: "Simran, your positive attitude and teamwork are invaluable. Thank you for being a great team player." },
        { name: "Khushboo Deewana", message: "Khushboo, your enthusiasm and energy bring a vibrant spirit to our team. Thank you for your lively contributions." },
        { name: "Manish Pathak", message: "Manish, your diligence and reliability make a real difference. Thank you for your hard work and commitment." },
        { name: "Mosam Parkar", message: "Mosam, your dedication to excellence is truly admirable. Thank you for your contributions to our projects." },
        { name: "Rutu Jadav", message: "Rutu Jadav, your dedication to excellence is truly admirable. Thank you for your contributions to our projects." },
        { name: "Zeel Barot", message: "Zeel, your creative solutions and positive mindset make you a valuable team member. Thank you for your hard work." },
        { name: "Kiran Gamar", message: "Kiran, your passion for our projects is contagious. Thank you for your enthusiasm and dedication." },
        { name: "Kirti Verma", message: "Kirti, your attention to detail and meticulous work are highly appreciated. Thank you for your contributions." },
        { name: "Minal.S.Chauhan", message: "Minal, your hard work and dedication have not gone unnoticed. Thank you for your valuable contributions to our team." },
        { name: "Pro. Tejas Modi", message: "Professor Tejas Modi, He is so Kind And Help me a lot For Inspire for my work. thank you so much." },
        { name: "Rutvi Dave", message: "Rutvi, your positive attitude and creative ideas bring a fresh perspective to our projects. Thank you for your contributions." },
        { name: "Kaveri Panchal", message: "Kaveri, your commitment to excellence is truly commendable. Thank you for your hard work and dedication." },
        { name: "Dipesh Dave", message: "Dipesh, your technical expertise and problem-solving skills make you an invaluable asset to our team. Thank you for your contributions." },
        { name: "Divyanshi Raval", message: "Divyanshi, your dedication and hard work shine through in everything you do. Thank you for your valuable contributions to our projects." },
        { name: "D. J. Patel", message: "Durgesh Patel, Thanks You for being a shining light in my life and inspiring me to be the best version of myself." },
        { name: "Honey S. Arya", message: "Honey, your positivity and resilience make a significant impact. Thank you for your contributions to our team." },
        { name: "Sky Cafe [Team]", message: "To the Sky Cafe Team, your collaborative efforts and hard work have made our projects a success. Thank you for being an amazing team." },
        { name: "Sukhdev Dan Gadhavi", message: "Sukhdev Dan (Australia), your spiritual guidance and support have been a source of strength. Thank you for your wisdom and teachings." },
        { name: "Smit Vyash", message: "Smit Vyash, your spiritual guidance and support have been a source of strength. Thank you for your wisdom and teachings." }
    ];
    const nameCardsContainer = document.getElementById('name-cards-container');
    const personListContainer = document.getElementById('personList');

    people.forEach(person => {
        // Create swiper slide
        const swiperSlide = document.createElement('div');
        swiperSlide.className = 'swiper-slide';
        swiperSlide.innerHTML = `
        <div class="card mb-4">
            <div class="card-header">
                Thank You
            </div>
            <div class="card-body">
                <h5 class="card-title">${person.name}</h5>
                <p class="card-text">
                    ${person.message}
                </p>
            </div>
        </div>
    `;

        nameCardsContainer.appendChild(swiperSlide);

        // Create list item for the modal
        const listItem = document.createElement('li');
        listItem.textContent = person.name;

        // Append list item to the modal container
        personListContainer.appendChild(listItem);
    });

    document.getElementById('personModal').addEventListener('show.bs.modal', function () {
        const personListContainer = document.getElementById('personList');
        personListContainer.innerHTML = '';


        const groupedPeople = groupBy(people, 'relationship');

        for (const relationship in groupedPeople) {
            if (groupedPeople.hasOwnProperty(relationship)) {
                const peopleInSection = groupedPeople[relationship];

                const sectionHeader = document.createElement('h4');
                sectionHeader.textContent = relationship;
                personListContainer.appendChild(sectionHeader);

                const sectionList = document.createElement('ul');
                peopleInSection.forEach(person => {
                    const listItem = document.createElement('li');
                    listItem.textContent = person.name;
                    sectionList.appendChild(listItem);
                });

                personListContainer.appendChild(sectionList);
            }
        }
    });

    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 2000,
        },
        speed: 500,
    });

</script>

</html>