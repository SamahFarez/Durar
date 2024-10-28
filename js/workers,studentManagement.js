const mainSection = document.getElementById('main-section');
const admins = document.getElementById('admins_list');
const teachers = document.getElementById('teachers_list');
const students = document.getElementById('studs_list');
const registrate = document.getElementById('registration');


// admins activating
const linkAdmins = document.querySelector('a[href="#admins_list"]');
linkAdmins.addEventListener('click', (event) => {
   event.preventDefault(); // prevent the default link behavior
   mainSection.style.display = 'none';
   admins.style.display = 'block';
   teachers.style.display = 'none';
   students.style.display = 'none';
   registrate.style.display = 'none';
});

// next exams activating
const linkTeachers = document.querySelector('a[href="#teachers_list"]');
linkTeachers.addEventListener('click', (event) => {
   event.preventDefault(); // prevent the default link behavior
   mainSection.style.display = 'none';
   admins.style.display = 'none';
   teachers.style.display = 'block';
   students.style.display = 'none';
   registrate.style.display = 'none';
});

// grades activating
const linkStudents = document.querySelector('a[href="#students_list"]');
linkStudents.addEventListener('click', (event) => {
   event.preventDefault(); // prevent the default link behavior
   mainSection.style.display = 'none';
   admins.style.display = 'none';
   teachers.style.display = 'none';
   students.style.display = 'block';
   registrate.style.display = 'none';
});

// grades activating
const linkRegistrate = document.querySelector('a[href="#registrate"]');
linkRegistrate.addEventListener('click', (event) => {
   event.preventDefault(); // prevent the default link behavior
   mainSection.style.display = 'none';
   admins.style.display = 'none';
   teachers.style.display = 'none';
   students.style.display = 'none';
   registrate.style.display = 'block';
});