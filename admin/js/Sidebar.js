const sidebar = document.querySelector('.sidebar');
const toggleBtn = document.createElement('div');
toggleBtn.classList.add('toggle-btn');
toggleBtn.innerHTML = '&#9776;';
document.body.appendChild(toggleBtn);
toggleBtn.addEventListener('click', ()=> sidebar.classList.toggle('collapsed'));
