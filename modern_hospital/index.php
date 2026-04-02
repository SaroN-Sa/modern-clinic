<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MediCare Hospital</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
  --primary:#0fb9a8;
  --dark:#0b1c2d;
  --light:#f5fefe;
  --gray:#6c757d;
}

*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',sans-serif;color:#222;background:#fff}

/* TOP BAR */
.topbar{
  background:var(--dark);
  color:#fff;
  padding:8px 40px;
  display:flex;
  justify-content:space-between;
  font-size:14px;
}

/* NAVBAR */
nav{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:18px 40px;
  background:#fff;
  box-shadow:0 4px 10px rgba(0,0,0,.05);
}
.brand{
  display:flex;align-items:center;gap:10px;
  font-size:22px;font-weight:700;color:var(--primary)
}
nav ul{list-style:none;display:flex;gap:25px}
nav a{text-decoration:none;color:#333;font-weight:500}
.btn{
  padding:10px 18px;border-radius:25px;
  text-decoration:none;font-weight:600;
}
.btn-primary{background:var(--primary);color:#fff}
.btn-outline{border:2px solid var(--primary);color:var(--primary)}

/* HERO */
.hero{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:40px;
  padding:80px 40px;
  background:linear-gradient(to right,#f7fffe,#ffffff);
  align-items:center;
}
.hero h1{font-size:48px;line-height:1.2}
.hero h1 span{color:var(--primary)}
.hero p{margin:20px 0;font-size:18px;color:#555}
.hero-buttons{display:flex;gap:15px;margin-top:20px}
.hero img{width:100%;border-radius:20px}

/* STATS */
.stats{
  background:var(--dark);
  color:#fff;
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
  padding:40px;
  text-align:center;
}
.stat h2{color:var(--primary);font-size:32px}

/* SERVICES */
.section{padding:80px 40px;text-align:center}
.section small{color:var(--primary);font-weight:600}
.services{
  margin-top:40px;
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
  gap:25px;
}
.service-card{
  background:#fff;
  padding:30px;
  border-radius:14px;
  box-shadow:0 10px 25px rgba(0,0,0,.08);
  text-align:left;
}
.service-card h4{margin:15px 0}
.service-card a{color:var(--primary);text-decoration:none;font-weight:600}

/* CTA */
.cta{
  background:linear-gradient(to right,#0fb9a8,#0aa79a);
  color:#fff;
  text-align:center;
  padding:70px 40px;
}
.cta a{
  background:#fff;
  color:var(--primary);
  padding:12px 25px;
  border-radius:25px;
  display:inline-block;
  margin-top:20px;
  font-weight:600;
}

/* FOOTER */
footer{
  background:var(--dark);
  color:#ccc;
  padding:60px 40px;
}
.footer-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:40px;
}
footer h4{color:#fff;margin-bottom:15px}
footer a{color:#ccc;text-decoration:none;display:block;margin-bottom:8px}
.footer-bottom{
  margin-top:40px;
  border-top:1px solid #333;
  padding-top:15px;
  display:flex;
  justify-content:space-between;
  font-size:14px;
}

/* RESPONSIVE */
@media(max-width:900px){
  .hero{grid-template-columns:1fr}
  .hero h1{font-size:36px}
  nav ul{display:none}
}
</style>
</head>

<body>

<!-- TOP BAR -->
<div class="topbar">
  <div>📞 +1 (555) 123-4567 &nbsp; | &nbsp; ✉ info@medicarehospital.com</div>
  <div>🕒 Mon – Fri: 8:00 AM – 8:00 PM</div>
</div>

<!-- NAVBAR -->
<nav>
  <div class="brand">MediCare</div>
  <ul>
    <li><a href="#">Home</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Services</a></li>
    <li><a href="#">Doctors</a></li>
    <li><a href="#">Contact</a></li>
  </ul>
  <div>
    <a href="appointment.php" class="btn btn-primary">Book Appointment</a>
    <a href="auth/login.php" class="btn btn-outline">Staff Portal</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div>
    <small>Trusted Healthcare Since 1995</small>
    <h1>Your Health, <span>Our Priority</span></h1>
    <p>World-class healthcare delivered by experienced specialists using advanced technology.</p>
    <div class="hero-buttons">
      <a href="appointment.php" class="btn btn-primary">Book Appointment</a>
      <a href="tel:+15551234567" class="btn btn-outline">Call Now</a>
    </div>
  </div>
  <div>
    <img src="https://images.unsplash.com/photo-1580281657527-47d43c07d5b1">
  </div>
</section>

<!-- STATS -->
<section class="stats">
  <div><h2>50,000+</h2><p>Patients Treated</p></div>
  <div><h2>25+</h2><p>Years Experience</p></div>
  <div><h2>100+</h2><p>Expert Doctors</p></div>
  <div><h2>24/7</h2><p>Emergency Care</p></div>
</section>

<!-- SERVICES -->
<section class="section">
  <small>WHAT WE OFFER</small>
  <h2>Our Medical Services</h2>
  <p>Comprehensive healthcare services delivered by experienced specialists.</p>

  <div class="services">
    <div class="service-card"><h4>Cardiology</h4><p>Expert heart care</p><a href="#">Learn More →</a></div>
    <div class="service-card"><h4>Neurology</h4><p>Advanced brain care</p><a href="#">Learn More →</a></div>
    <div class="service-card"><h4>Orthopedics</h4><p>Bone & joint care</p><a href="#">Learn More →</a></div>
    <div class="service-card"><h4>Pediatrics</h4><p>Child healthcare</p><a href="#">Learn More →</a></div>
    <div class="service-card"><h4>Ophthalmology</h4><p>Eye care services</p><a href="#">Learn More →</a></div>
    <div class="service-card"><h4>General Medicine</h4><p>Primary healthcare</p><a href="#">Learn More →</a></div>
  </div>
</section>

<!-- CTA -->
<section class="cta">
  <h2>Need Medical Assistance?</h2>
  <p>Book an appointment today and let our experts take care of you.</p>
  <a href="appointment.php">Schedule Your Visit</a>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-grid">
    <div>
      <h4>MediCare</h4>
      <p>Exceptional healthcare with compassion and excellence since 1995.</p>
    </div>
    <div>
      <h4>Quick Links</h4>
      <a href="#">Home</a><a href="#">About</a><a href="#">Services</a><a href="#">Doctors</a><a href="#">Contact</a>
    </div>
    <div>
      <h4>Our Services</h4>
      <a>Emergency Care</a><a>Cardiology</a><a>Neurology</a><a>Orthopedics</a><a>Pediatrics</a>
    </div>
    <div>
      <h4>Contact Info</h4>
      <p>📍 123 Medical Center Drive</p>
      <p>📞 +1 (555) 123-4567</p>
      <p>✉ info@medicarehospital.com</p>
      <p>🚑 24/7 Emergency</p>
    </div>
  </div>

  <div class="footer-bottom">
    <span>© 2024 MediCare Hospital</span>
    <span>Privacy Policy | Terms</span>
  </div>
</footer>

</body>
</html>
