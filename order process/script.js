function nextStep() {
  alert('Proceed to Payment Detail');
}
// Select all steps
const steps = document.querySelectorAll('.step');

// Add click event listener to each step
steps.forEach((step, index) => {
  step.addEventListener('click', () => {
      // Remove 'active' class from all steps
      steps.forEach(s => s.classList.remove('active'));
      
      // Add 'active' class to the clicked step
      step.classList.add('active');
  });
});


