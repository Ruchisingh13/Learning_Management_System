<?php
include_once("Inc/Header.php");
include_once("DB_Files/db.php");
?>

<link rel="stylesheet" href="CSS/Home.css">
<link rel="stylesheet" href="CSS/responsiveness.css">
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

<!-- Header -->
<header>
    <div class="container header__container">
        <div class="header__left">
            <h1>Grow your Skills to Advance your Career path</h1>
            <p>Education is the place where learning begins but ends nowhere.</p>
            <?php
            if (isset($_SESSION['stu_id'])) {
                echo '<a href="Users/Profile.php"><button class="button"> Visit Profile </button></a>';
            } else {
                echo '<a href="Login&SignIn.php"><button class="button">Get Started </button></a>';
            }
            ?>
        </div>
        <div class="header__right">
            <div class="header__right-image">
                <img src="Img/header.svg" alt="">
            </div>
        </div>
    </div>
</header>

<!-- Categories Section -->
<section class="categories reveal">
    <div class="container categories__container">
        <div class="categories__left">
            <h1>Categories</h1>
            <p>Students can learn their programming languages very easily with good knowledge capacity from Imperial Academy.</p>
        </div>
        <div class="categories__right">
            <!-- Repeat of categories omitted for brevity -->
        </div>
    </div>
</section>

<!-- Popular Course Section -->
<section class="courses reveal">
    <h2>Our Popular Course</h2>
    <div class="container courses__container">
        <?php
        $sql = "SELECT * FROM course ORDER BY RAND() LIMIT 6";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $course_id = $row['course_id'];
                echo '
                <article class="course">
                <a href="CourseDetails.php?course_id='.$course_id.'">
                <div class="course__image">
                    <img src="'.str_replace('..','.',$row['course_img']).'" alt="">
                </div>
                <div class="course__info">
                    <h3 style="text-align: start;">' . $row['course_name'] . '</h3>
                    <h5 style="text-align: start; margin-top: 10px;">' . $row['course_author'] . '</h5>
                    <h4 style="text-align: start; margin-top: 10px;">&#8377;' . $row['course_price'] . '</h4>
                    <br>
                    <button class="button">Learn More</button>
                </div>
                </a>
                </article>';
            }
        }
        ?>
    </div>
</section>

<!-- Testimonial -->
<section class="container testimonials__container mySwiper reveal">
    <h2>Students Reviews</h2>
    <div class="swiper-wrapper">
        <?php
        $sql = "SELECT s.stu_name,s.stu_occ,s.stu_img,f.f_content FROM students As s JOIN feedback As f ON s.stu_id=f.stu_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $s_img = str_replace('..', '.', $row['stu_img']);
                echo '
                <article class="testimonial swiper-slide">
                    <div class="avatar">
                        <img src="'.$s_img.'" alt="">
                    </div>
                    <div class="testimonial__info">
                        <h5>' . $row['stu_name'] . '</h5>
                        <small>' . $row['stu_occ'] . '</small>
                    </div>
                    <div class="testimonial__body">
                        <p>' . $row['f_content'] . '</p>
                    </div>
                </article>';
            }
        }
        ?>
    </div>
    <div class="swiper-pagination"></div>
</section>

<!-- Awesome Features -->
<section id="features" class="reveal">
    <h1>Awesome Features</h1>
    <div class="fea-base">
        <div class="fea-box"><i class="uil uil-graduation-cap"></i><h3>Scholarship Facility</h3></div>
        <div class="fea-box"><i class="uil uil-trophy"></i><h3>Global Recognition</h3></div>
        <div class="fea-box"><i class="uil uil-clipboard-alt"></i><h3>Enroll Course</h3></div>
    </div>
</section>

<!-- Chatbot Button and Chatbox HTML -->
<div id="chatbot-toggle" style="position:fixed; bottom:20px; right:20px; background:#2563eb; color:white; width:60px; height:60px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:30px; cursor:pointer; box-shadow:0 4px 10px rgba(0,0,0,0.2); z-index:1000;">
    💬
</div>

<div id="chatbot-window" style="display:none; position:fixed; bottom:90px; right:20px; width:300px; height:400px; background:white; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.2); overflow:hidden; flex-direction:column; z-index:1000;">
    <div style="background:#2563eb; color:white; padding:10px; text-align:center; font-weight:bold;">
        BOLT Chatbot
    </div>
    <div id="chatbot-messages" style="flex:1; padding:10px; overflow-y:auto; font-size:0.9rem; background:#f9fafb;">
        <div style="color:#6b7280;">Hi there! Ask me anything about our courses! 🎓</div>
    </div>
    <form id="chatbot-form" style="display:flex; border-top:1px solid #ddd;">
        <input type="text" id="chatbot-input" placeholder="Type your question..." style="flex:1; border:none; padding:10px; font-size:0.9rem;">
        <button type="submit" style="background:#2563eb; border:none; color:white; padding:0 15px; cursor:pointer;">➤</button>
    </form>
</div>

<?php include_once("Inc/Footer.php"); ?>




<!-- Scripts -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script>
// Swiper Slider
var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        600: {
            slidesPerView: 3
        }
    }
});

// Reveal on scroll
function reveal() {
    var reveals = document.querySelectorAll(".reveal");
    for (var i = 0; i < reveals.length; i++) {
        var windowHeight = window.innerHeight;
        var elementTop = reveals[i].getBoundingClientRect().top;
        var elementVisible = 150;
        if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add("active");
        } else {
            reveals[i].classList.remove("active");
        }
    }
}
window.addEventListener("scroll", reveal);

// Chatbot Functionality
const chatbotToggle = document.getElementById('chatbot-toggle');
const chatbotWindow = document.getElementById('chatbot-window');
const chatbotForm = document.getElementById('chatbot-form');
const chatbotInput = document.getElementById('chatbot-input');
const chatbotMessages = document.getElementById('chatbot-messages');

chatbotToggle.addEventListener('click', () => {
    if (chatbotWindow.style.display === 'none' || chatbotWindow.style.display === '') {
        chatbotWindow.style.display = 'flex';
    } else {
        chatbotWindow.style.display = 'none';
    }
});

chatbotForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const userMessage = chatbotInput.value.trim();
    if (userMessage === '') return;
    addMessage(userMessage, 'user');
    chatbotInput.value = '';

    setTimeout(() => {
        addMessage(getBotReply(userMessage), 'bot');
    }, 800);
});

function addMessage(message, sender) {
    const div = document.createElement('div');
    div.style.margin = '8px 0';
    div.style.color = sender === 'user' ? '#111827' : '#6b7280';
    div.textContent = message;
    chatbotMessages.appendChild(div);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}

function getBotReply(message) {
    message = message.toLowerCase();
    if (message.includes('price') || message.includes('cost')) {
      return 'You can view the course price in each card. Let me know if you need help!';
    } else if (message.includes('availability') || message.includes('stock')) {
      return 'All available courses are shown. Let us know if you’re looking for something specific.';
    } else if (message.includes('delivery') || message.includes('shipping')) {
      return 'Courses are delivered online immediately after purchase.';
    } else if (message.includes('return') || message.includes('refund')) {
      return 'Sorry, we do not offer refunds for digital courses.';
    }

    // 50+ Intelligent QnA
    else if (message.includes('certificate')) {
      return 'Yes, you will receive a certificate after completing the course.';
    } else if (message.includes('duration')) {
      return 'Each course varies in duration. It is mentioned in the course description.';
    } else if (message.includes('language')) {
      return 'Most courses are in English, and some offer subtitles in other languages.';
    } else if (message.includes('support') || message.includes('help')) {
      return 'You can contact our support team via the Contact page anytime.';
    } else if (message.includes('free course')) {
      return 'Yes, we offer free courses. Check the homepage for available ones.';
    } else if (message.includes('job') || message.includes('placement')) {
      return 'We provide career guidance but not guaranteed placements.';
    } else if (message.includes('internship')) {
      return 'Yes, internship opportunities are offered to top-performing students.';
    } else if (message.includes('quiz')) {
      return 'Most courses include quizzes and assignments to test your knowledge.';
    } else if (message.includes('login issue') || message.includes('login problem')) {
      return 'Please reset your password or contact support if login fails.';
    } else if (message.includes('discount') || message.includes('offer')) {
      return 'Seasonal offers and discounts are listed on the homepage!';
    } else if (message.includes('beginner')) {
      return 'Yes, we have beginner-friendly courses available in every category.';
    } else if (message.includes('advanced')) {
      return 'Advanced-level courses are available for those who want to dive deeper.';
    } else if (message.includes('reset password')) {
      return 'Go to the Login page and click “Forgot Password” to reset.';
    } else if (message.includes('contact')) {
      return 'Visit our Contact page to get in touch directly with our team.';
    } else if (message.includes('video quality')) {
      return 'Our courses are delivered in HD with clear audio and visuals.';
    } else if (message.includes('mobile') || message.includes('app')) {
      return 'You can access our platform on any mobile browser. App version is coming soon.';
    } else if (message.includes('access after completion')) {
      return 'Yes, you have lifetime access to courses once purchased.';
    } else if (message.includes('doubt') || message.includes('question')) {
      return 'You can ask your questions in the student forum of each course.';
    } else if (message.includes('live class')) {
      return 'We provide live sessions in selected premium courses.';
    } else if (message.includes('how to enroll') || message.includes('enroll')) {
      return 'Click “Get Started” or “Learn More” on a course to enroll.';
    } else if (message.includes('what is imperial academy')) {
      return 'Imperial Academy is an online learning platform offering tech courses.';
    } else if (message.includes('ui ux')) {
      return 'Yes, we have both UI and UX design courses for beginners and pros.';
    } else if (message.includes('full stack')) {
      return 'We offer full stack developer courses including MERN, LAMP and more.';
    } else if (message.includes('python')) {
      return 'Yes, Python programming courses are available under Programming section.';
    } else if (message.includes('java')) {
      return 'We have beginner to advanced Java courses available.';
    } else if (message.includes('javascript')) {
      return 'JavaScript is part of our Web Development curriculum.';
    } else if (message.includes('html') || message.includes('css')) {
      return 'HTML and CSS are taught in Front-End Development courses.';
    } else if (message.includes('certificate verification')) {
      return 'You can verify your certificate via your student profile page.';
    } else if (message.includes('weekend')) {
      return 'Courses are self-paced. You can learn anytime, including weekends.';
    } else if (message.includes('who is instructor') || message.includes('trainer')) {
      return 'Instructor details are mentioned on each course page.';
    } else if (message.includes('project based')) {
      return 'Yes, we provide project-based learning in most courses.';
    } else if (message.includes('github')) {
      return 'Some courses offer source code on GitHub. Check course materials.';
    } else if (message.includes('database')) {
      return 'Yes, we teach MySQL, MongoDB and Firebase in backend courses.';
    } else if (message.includes('frontend') || message.includes('back end')) {
      return 'We offer both frontend and backend development training.';
    } else if (message.includes('ai') || message.includes('chatbot')) {
      return 'AI and chatbot development courses are under our Tech category.';
    } else if (message.includes('video paused') || message.includes('not loading')) {
      return 'Try refreshing the page or switching browsers. Contact support if needed.';
    } else if (message.includes('browser support')) {
      return 'Our platform supports Chrome, Firefox, Safari, and Edge.';
    } else if (message.includes('install certificate')) {
      return 'Certificates can be downloaded as PDF and printed or shared.';
    } else if (message.includes('payment')) {
      return 'We accept debit/credit cards, UPI, and PayPal.';
    } else if (message.includes('emi')) {
      return 'Currently, we don’t support EMI options.';
    } else if (message.includes('courses list')) {
      return 'You can view all available courses on the homepage.';
    } else if (message.includes('language support')) {
      return 'Currently, our primary language is English.';
    } else if (message.includes('mentor')) {
      return 'Mentors are assigned in premium mentorship programs.';
    } else if (message.includes('community')) {
      return 'Join our Discord or WhatsApp groups for community learning.';
    } else if (message.includes('upgrade')) {
      return 'You can upgrade to premium anytime from your dashboard.';
    } else if (message.includes('deadline')) {
      return 'Most courses are self-paced and have no deadlines.';
    } else if (message.includes('lifetime')) {
      return 'Yes, once purchased, you get lifetime access.';
    } else {
      return 'I am still learning! For more help, reach out via the Contact page.';
    }
  
}
</script>
