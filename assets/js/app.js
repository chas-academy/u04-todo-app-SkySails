const sendEvent = (type, source = document.body) =>
  source.dispatchEvent(
    new CustomEvent(type, {
      bubbles: true,
      data: source,
    })
  );

function openForm({ currentTarget: ct }) {
  const todoEl = ct.parentElement;
  todoEl.classList.toggle("show-form");
  todoEl.querySelector(".title-textarea").focus();
  todoEl.querySelector(".title-textarea").select();

  const outsideListener = (e) => {
    if (e.target !== todoEl && !todoEl.contains(e.target)) {
      todoEl.classList.toggle("show-form");
      document.removeEventListener("click", this);
      removeListener();
    }
  };

  const removeListener = () => {
    document.removeEventListener("click", outsideListener);
  };

  setTimeout(() => {
    document.addEventListener("click", outsideListener);
  }, 0);
}

function handleEditTodo(e) {
  const parent = e.target.parentElement;

  if (["P", "H3"].includes(e.target.tagName)) {
    const textarea = document.createElement("textarea");
    const originalEl = e.target;
    textarea.value = originalEl.innerText;
    textarea.oninput = (e) => adjustTAHeight(e);
    textarea.onblur = (e) => {
      const parent = e.target.parentElement;
      originalEl.innerText = e.target.value;
      parent.replaceChild(originalEl, e.target);
      sendEvent("update", parent);
    };
    textarea.className =
      e.target.tagName === "P" ? "content-textarea" : "title-textarea";

    parent.replaceChild(textarea, e.target);

    const tArea = parent.querySelector("textarea");
    tArea.style.height = tArea.scrollHeight + "px";
    tArea.focus();
  }
}

function adjustTAHeight(e) {
  const textarea = e.currentTarget;
  textarea.style.height = ""; /* Reset the height*/
  textarea.style.height = textarea.scrollHeight + "px";
}

function updateLists() {
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("list-container").innerHTML = this.responseText;
    }
  };
  xmlhttp.open("GET", "renderajax", true);
  xmlhttp.send();
}

function dbfetch(path, options = {}) {
  fetch(path, options)
    .then((response) => {
      if (!response.ok) {
        return Promise.reject(response);
      }
      return response.json();
    })
    .then((data) => {
      console.info("Success!", data);
      updateLists(); // Refresh page using AJAX
    })
    .catch((error) => {
      if (typeof error.json === "function") {
        error
          .json()
          .then((jsonError) => {
            console.error("Error from API: ", jsonError);
          })
          .catch((genericError) => {
            console.error("Error from API: ", genericError);
            console.error(error.statusText);
          });
      } else {
        console.error("Fetch error: ", error);
      }
    });
}

function handleTodoForm(e) {
  e.preventDefault();
  const form = e.target;
  const listID = parseInt(e.target.closest("section").dataset.listid);
  const { title, description } = form.elements;

  form.closest(".todo-new-card").classList.add("loading");

  dbfetch("/api/items", {
    method: "POST",
    body: new URLSearchParams({
      title: title.value,
      description: description.value,
      list_id: listID,
    }),
  });
}

function updateTodo(e) {
  const todoEl = e.target.closest(".todo-card");
  const id = todoEl.dataset.todoid;
  const title = todoEl.querySelector(".todo-card__title").innerText;
  const description = todoEl.querySelector(".todo-card__description").innerText;
  const status = todoEl.querySelector("input[type='checkbox']").checked ? 1 : 0;
  // console.log(status, id, title, description);

  dbfetch("/api/items/" + id, {
    method: "PATCH",
    body: new URLSearchParams({
      title,
      description,
      status,
    }),
  });
}

document.addEventListener("update", (e) => updateTodo(e));

function deleteTodo(e) {
  e.preventDefault();
  const todoEl = e.target.closest(".todo-card");
  const id = todoEl.dataset.todoid;

  dbfetch("/api/items/" + id, {
    method: "DELETE",
  });
}

function addList(e) {
  e.preventDefault();
  const name = e.target.elements.name.value;

  dbfetch("/api/lists", {
    method: "POST",
    body: new URLSearchParams({
      name,
    }),
  });
}

function deleteList(e) {
  const listID = e.currentTarget.closest("section").dataset.listid;

  dbfetch("/api/lists/" + listID, {
    method: "DELETE",
  });
}

// DROPDOWN Functions

function toggleDropdown(e) {
  const ddEl = e.currentTarget.nextElementSibling;
  ddEl.classList.toggle("show");

  setTimeout(() => {
    document.addEventListener("click", () => ddEl.classList.toggle("show"), {
      once: true,
    });
  }, 0);
}
