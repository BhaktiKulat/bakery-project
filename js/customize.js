// State Object
const state = {
    type: 'Cake',
    basePrice: 400,
    shape: 'Round',
    qty: 1,
    flavor: 'Vanilla',
    flavorColor: '#ffe0b2',
    frosting: 'None',
    frostingColor: 'transparent',
    topping: 'None',
    toppingPrice: 0,
    instructions: ''
};

// Next/Prev Step Logic
function nextStep(stepNumber) {
    document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
    document.getElementById(`step-${stepNumber}`).classList.add('active');
    updateSummary();
}

// Event Listeners for Selections
document.querySelectorAll('.type-option').forEach(el => {
    el.addEventListener('click', function() {
        document.querySelectorAll('.type-option').forEach(e => e.classList.remove('selected'));
        this.classList.add('selected');
        state.type = this.dataset.type;
        state.basePrice = parseInt(this.dataset.basePrice);
        updateSummary();
    });
});

document.querySelectorAll('.shape-option').forEach(el => {
    el.addEventListener('click', function() {
        document.querySelectorAll('.shape-option').forEach(e => e.classList.remove('selected'));
        this.classList.add('selected');
        state.shape = this.dataset.shape;
        // Update visual shape class
        const vBase = document.getElementById('v-base');
        vBase.className = 'cake-base'; // reset
        if (state.shape === 'Square') vBase.classList.add('cake-shape-square');
        if (state.shape === 'Heart') vBase.classList.add('cake-shape-heart');
        updateSummary();
    });
});

document.getElementById('qty-select').addEventListener('change', function() {
    state.qty = parseInt(this.value);
    updateSummary();
});

// Builder Tabs
document.querySelectorAll('.builder-tab').forEach(el => {
    el.addEventListener('click', function() {
        document.querySelectorAll('.builder-tab').forEach(e => e.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.builder-panel').forEach(p => p.style.display = 'none');
        document.getElementById(this.dataset.target).style.display = 'block';
    });
});

// Flavor Options
document.querySelectorAll('.flavor-option').forEach(el => {
    el.addEventListener('click', function() {
        document.querySelectorAll('.flavor-option').forEach(e => e.classList.remove('selected'));
        this.classList.add('selected');
        state.flavor = this.dataset.flavor;
        state.flavorColor = this.dataset.color;
        document.getElementById('v-base').style.background = state.flavorColor;
        updateSummary();
    });
});

// Frosting Options
document.querySelectorAll('.frost-option').forEach(el => {
    el.addEventListener('click', function() {
        document.querySelectorAll('.frost-option').forEach(e => e.classList.remove('selected'));
        this.classList.add('selected');
        state.frosting = this.dataset.frost;
        state.frostingColor = this.dataset.color;
        
        // Add shadow for white cream so it's visible on white bg
        if(state.frostingColor === '#ffffff') {
            document.getElementById('v-frosting').style.background = state.frostingColor;
            document.getElementById('v-frosting').style.boxShadow = "0 2px 5px rgba(0,0,0,0.1)";
        } else {
            document.getElementById('v-frosting').style.background = state.frostingColor;
            document.getElementById('v-frosting').style.boxShadow = "none";
        }
        updateSummary();
    });
});

// Topping Options
document.querySelectorAll('.top-option').forEach(el => {
    el.addEventListener('click', function() {
        document.querySelectorAll('.top-option').forEach(e => e.classList.remove('selected'));
        this.classList.add('selected');
        state.topping = this.dataset.top;
        state.toppingPrice = parseInt(this.dataset.price || 0);
        
        // Visual updates
        document.getElementById('v-cherry').style.background = 'transparent';
        document.getElementById('v-sprinkles').style.opacity = '0';
        
        if (state.topping === 'Cherry') {
            document.getElementById('v-cherry').style.background = '#d32f2f'; // Red cherry
        } else if (state.topping === 'Sprinkles') {
            document.getElementById('v-sprinkles').style.opacity = '1';
        }

        updateSummary();
    });
});

// Update Summary Panel
function updateSummary() {
    document.getElementById('sum-type').innerText = state.type;
    document.getElementById('sum-shape').innerText = state.shape;
    document.getElementById('sum-qty').innerText = state.qty;
    document.getElementById('sum-flavor').innerText = state.flavor;
    document.getElementById('sum-frosting').innerText = state.frosting;
    document.getElementById('sum-topping').innerText = state.topping;

    const total = (state.basePrice + state.toppingPrice) * state.qty;
    document.getElementById('total-price').innerText = total;
}

// Initialize summary
updateSummary();
document.querySelector('.type-option[data-type="Cake"]').classList.add('selected');

// Cart Logic
function addToCart() {
    state.instructions = document.getElementById('special-instructions').value;
    const finalItem = {
        id: 'custom_' + Date.now(),
        name: `Custom ${state.type}`,
        price: (state.basePrice + state.toppingPrice),
        quantity: state.qty,
        image: 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=200&auto=format&fit=crop', // generic fallback
        customization: state
    };

    let cart = JSON.parse(localStorage.getItem('bakery_cart')) || [];
    cart.push(finalItem);
    localStorage.setItem('bakery_cart', JSON.stringify(cart));
    
    alert('Custom dessert added to cart successfully!');
    window.location.href = 'cart.html';
}
