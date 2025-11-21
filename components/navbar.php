


<?php



$current = basename($_SERVER['PHP_SELF']);
function isActive($name) {
    global $current;
    return $current === $name ? 'active' : '';
}

// Example: if you set $_SESSION['user_name'] when logged in, it will show as logged in.
$loggedIn = !empty($_SESSION['user_name']);
$userName = $loggedIn ? htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') : '';
?>
<style>
/* New navbar styles (adapted from provided snippet) */
.h-navbar{
    position: sticky;
    top: 0;
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 14px 28px;
    background: linear-gradient(180deg, rgba(255,255,255,0.75), rgba(255,255,255,0.6));
    backdrop-filter: blur(6px);
    transition: box-shadow .2s, padding .2s;
}

/* Optional scrolled state (toggle class .scrolled with JS if desired) */
.h-navbar.scrolled { box-shadow: var(--shadow, 0 6px 18px rgba(0,0,0,0.08)); padding: 10px 28px; }

.brand{
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
    color: var(--primary, #0d6efd);
    text-decoration: none;
}
.brand .mark{
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary, #0d6efd), #1b82ff);
    display: inline-grid;
    place-items: center;
    color: #fff;
    font-weight: 700;
    box-shadow: 0 6px 18px rgba(11,110,253,0.18);
}

/* menu list (keeps same markup but styled to the new spec) */
.nav-links, .menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    gap: 18px;
    align-items: center;
    margin-left: 12px;
}
.menu li { margin: 0; }

.menu a, .nav-links a{
    color: var(--muted, #6c757d);
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    padding: 8px 6px;
    border-radius: 8px;
    display: inline-block;
}
.menu a:hover, .nav-links a:hover{
    color: var(--primary, #0d6efd);
    background: rgba(11,110,253,0.06);
}

/* active link */
.nav-links li.active a, .menu li.active a {
    background: rgba(11,110,253,0.12);
    color: var(--primary, #0d6efd);
}

/* actions / buttons */
.btn{
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    border: 0;
    text-decoration: none;
}
.btn-outline{
    background: transparent;
    color: var(--primary, #0d6efd);
    border: 1px solid rgba(11,110,253,0.12);
}
.btn-primary{
    background: var(--primary, #0d6efd);
    color: #fff;
    box-shadow: 0 8px 24px rgba(11,110,253,0.12);
}

/* toggle button */
.nav-toggle {
    display: none;
    font-size: 1.2rem;
    cursor: pointer;
    background: transparent;
    border: 0;
    color: black;
}

/* Responsive: collapse into column on small screens */
@media (max-width: 700px) {
    .h-navbar { align-items: flex-start;
    background:#fff }
    .nav-toggle { display: block; 
    position: absolute;
    right:2px;
    }
    .nav-links, .menu {
        width: 100%;
        flex-direction: column;
        display: none;
        margin-top: 0.5rem;
    }
    .nav-links.show, .menu.show { display: flex; }
    .nav-links li a, .menu li a { padding: 0.6rem; }
}
</style>

<nav class="h-navbar" aria-label="Main navigation">
    <a class="brand" href="/index.php"><span class="mark">H</span> <span class="brand-text">Hospital</span></a>

    <button class="nav-toggle" aria-expanded="false" aria-label="Toggle navigation" onclick="document.querySelector('.nav-links').classList.toggle('show'); this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true');">
        <span class="toggle-icon" aria-hidden="true" onclick="const btn=this.closest('button'); this.textContent = this.textContent === '☰' ? '✕' : '☰'; btn.setAttribute('aria-label', this.textContent === '✕' ? 'Close navigation' : 'Toggle navigation');">☰</span>
    </button>
    <!--  -->
   

    <ul class="nav-links menu">
        <li class="<?= isActive('home.php') ?>"><a href="../home.php">Home</a></li>
        <li class="<?= isActive('services.php') ?>"><a href="../pages/services.php">Services</a></li>
         <li class="<?= isActive('doctors.php') ?>"><a href="../pages/doctors.php">Doctors</a></li>
        <li class="<?= isActive('about.php') ?>"><a href="../pages/about.php">About Us</a></li>
        <li class="<?= isActive('book.php') ?>"><a class="btn " href="../pages/appointment.php">Book Appointment</a></li>





<!-- login or profile -->

        <?php if ($loggedIn): ?>
            <li class="<?= isActive('dashboard.php') ?>"><a class="btn btn-outline" href="../user/patientprofile.php">My Profile</a></li>
            <li><a class="btn btn-outline" href="../authentication/logout.php">Logout
                
                </a></li>
        <?php else: ?>
             <li class="<?= isActive('login.php') ?>"><a class="btn btn-outline" href="../authentication/login.php">Login</a></li> 

<!--end login or profile  -->


<!-- end -->





        <?php endif; ?>
    </ul>
</nav>

