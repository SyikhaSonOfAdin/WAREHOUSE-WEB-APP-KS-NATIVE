const modalHandler = document.getElementById('modalButton') ;
const modal = document.getElementById('modal') ;
const cancel = document.getElementById('cancel') ;

modalHandler.addEventListener('click', () => {
    modal.classList.toggle('fixed')
    modal.classList.toggle('hidden')
})
cancel.addEventListener('click', () => {
    modal.classList.toggle('fixed')
    modal.classList.toggle('hidden')
})