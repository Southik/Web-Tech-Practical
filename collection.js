function addToCdollection() {
  const title = document.querySelector(".page-title").textContent;
  const price = document.querySelector(".product-price").textContent;
  const quantity = document.querySelector(".quantity-input").value;
  
  const list = document.getElementById("collection-list");
  const entry = document.createElement("li");
  entry.textContent = `${title} | Price: ${price} | Qty: ${quantity}`;
  list.appendChild(entry);
}

function addToCollection() {
  const title = document.querySelector(".page-title").textContent;
  const price = document.querySelector(".product-price").textContent;
  const quantity = Number(document.querySelector(".quantity-input").value);
  const list = document.getElementById("collection-list");

  // Find if product already exists in the list
  const items = list.getElementsByTagName("li");
  let found = false;

  for (let i = 0; i < items.length; i++) {
    if (items[i].dataset.title === title) {
      // Product found, update quantity
      let prevQty = Number(items[i].dataset.quantity);
      let newQty = prevQty + quantity;
      items[i].dataset.quantity = newQty;
      items[i].textContent = `${title} | Price: ${price} | Qty: ${newQty}`;
      found = true;
      break;
    }
  }

  // If not found, add new entry
  if (!found) {
    const entry = document.createElement("li");
    entry.dataset.title = title;
    entry.dataset.quantity = quantity;
    entry.textContent = `${title} | Price: ${price} | Qty: ${quantity}`;
    list.appendChild(entry);
  }
}

function removeOneFromList() {
  const list = document.getElementById("collection-list");
  const firstEntry = list.querySelector("li");
  if (!firstEntry) return; // List is empty, do nothing

  let quantity = Number(firstEntry.dataset.quantity);
  if (quantity > 1) {
    quantity--;
    firstEntry.dataset.quantity = quantity;
    firstEntry.textContent = `${firstEntry.dataset.title} | Price: ${firstEntry.dataset.price} | Qty: ${quantity}`;
  } else {
    list.removeChild(firstEntry);
  }
}
