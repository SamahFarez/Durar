const mainSection = document.getElementById('main-section');
const epsReports = document.getElementById('episodes_reports');
const absStats = document.getElementById('absence_stats');
const learningStats = document.getElementById('learning_stats');
const examAdmin = document.getElementById('exams_admin');


// episode reports activating
const linkEpsReports = document.querySelector('a[href="#eps_reports"]');
linkEpsReports.addEventListener('click', (event) => {
   event.preventDefault(); // prevent the default link behavior
   mainSection.style.display = 'none';
   absStats.style.display = 'none';
   learningStats.style.display = 'none';
   examAdmin.style.display = 'none';
   epsReports.style.display = 'block';
});

// next exams activating
const linkAbsStats = document.querySelector('a[href="#absence"]');
linkAbsStats.addEventListener('click', (event) => {
   event.preventDefault(); // prevent the default link behavior
   mainSection.style.display = 'none';
   absStats.style.display = 'block';
   epsReports.style.display = 'none';
   learningStats.style.display = 'none';
   examAdmin.style.display = 'none';
});

// grades activating
const linkLearning = document.querySelector('a[href="#learning"]');
linkLearning.addEventListener('click', (event) => {
   event.preventDefault(); // prevent the default link behavior
   mainSection.style.display = 'none';
   examAdmin.style.display = 'none';
   epsReports.style.display = 'none';
   learningStats.style.display = 'block';
   absStats.style.display = 'none';
});

// exam button activating
const linkExams = document.querySelector('a[href="#exams"]');
linkExams.addEventListener('click', (event) => {
   event.preventDefault(); // prevent the default link behavior
   mainSection.style.display = 'none';
   examAdmin.style.display = 'block';
   epsReports.style.display = 'none';
   learningStats.style.display = 'none';
   absStats.style.display = 'none';
});