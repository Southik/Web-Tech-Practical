function getTotalPrice(priceWOTax) {
    return priceWOTax * 1.19; 
}

function showTotalPrice() {
    const input = document.getElementById("priceWOTax");
    const output = document.getElementById("price-result");

    const priceWOTax = Number(input.value);

    if (!priceWOTax || priceWOTax < 0) {
        output.textContent = "Please enter a valid price.";
        return;
    }

    const priceWithTax = getTotalPrice(priceWOTax);

    output.textContent =
        `Without tax: €${priceWOTax.toFixed(2)} | With tax (19%): €${priceWithTax.toFixed(2)}`;
}

function togglePrices() {
    const prices = document.querySelectorAll(".product-price");
    if (prices.length === 0) return;

    prices.forEach(p => {
        if (p.style.display === "none") {
            p.style.display = "block";
        } else {
            p.style.display = "none";
        }
    });

    console.log("Toggled prices visibility.");
}

function highlightExpensive() {
    const prices = document.querySelectorAll(".product-price");

    prices.forEach(priceElement => {
        let text = priceElement.textContent.replace("€", "").trim();
        let value = parseFloat(text);

        if (value > 80) {
            priceElement.style.backgroundColor = "yellow";
            priceElement.style.fontWeight = "bold";
        } else {
            priceElement.style.backgroundColor = "";
            priceElement.style.fontWeight = "";
        }
    });

    console.log("Expensive items highlighted.");
}
