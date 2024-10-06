// script.js

const API_BASE_URL = "http://127.0.0.1:8000/api"; // Adjust this if needed
let currentProjectId = null; // Global variable to store the currently selected project ID

document.addEventListener("DOMContentLoaded", () => {
    loadProjects();

    // Event listener for adding a project
    document
        .getElementById("add-project-btn")
        .addEventListener("click", addProject);

    // Event listener for adding a task
    document.getElementById("add-task-btn").addEventListener("click", addTask);
});

// Load all projects
async function loadProjects() {
    const response = await fetch(`${API_BASE_URL}/projects`);
    const projects = await response.json();
    const projectsList = document.getElementById("projects-list");
    projectsList.innerHTML = "";

    projects.forEach((project) => {
        const listItem = document.createElement("li");
        listItem.className = "list-group-item list-group-item-action";
        listItem.textContent = project.name;
        listItem.addEventListener("click", () =>
            loadProjectDetails(project.id)
        );
        projectsList.appendChild(listItem);
    });
}

// Load details for a single project
async function loadProjectDetails(projectId) {
    const projectResponse = await fetch(
        `${API_BASE_URL}/projects/${projectId}`
    );
    const project = await projectResponse.json();

    // Display project details
    document.getElementById("project-title").textContent = project.name;
    document.getElementById("project-description").textContent =
        project.description || "No description provided.";
    document.getElementById("project-details").style.display = "block";

    // Store the selected project ID globally
    currentProjectId = projectId;

    // Load tasks for this project
    loadTasks(projectId);
}

// Load all tasks for a given project
async function loadTasks(projectId) {
    const response = await fetch(`${API_BASE_URL}/projects/${projectId}/tasks`);
    const tasks = await response.json();
    const tasksList = document.getElementById("tasks-list");
    tasksList.innerHTML = "";

    tasks.forEach((task) => {
        const listItem = document.createElement("li");
        listItem.className =
            "list-group-item d-flex justify-content-between align-items-center";
        listItem.innerHTML = `
            <span>${task.name}</span>
            <span class="task-status ${task.status}">${task.status}</span>
        `;
        tasksList.appendChild(listItem);
    });
}

// Add a new project
async function addProject() {
    // Run the validation before sending the data
    if (!validateProjectForm()) {
        return; // Exit if validation fails
    }

    const projectName = document.getElementById("project-name").value;
    if (!projectName) return;

    await fetch(`${API_BASE_URL}/projects`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ name: projectName, description: "" }),
    });

    document.getElementById("project-name").value = "";
    loadProjects();
}

// Delete a project
async function deleteProject(projectId) {
    await fetch(`${API_BASE_URL}/projects/${projectId}`, { method: "DELETE" });
    document.getElementById("project-details").style.display = "none";
    loadProjects();
}

// Add a new task to the currently selected project
async function addTask() {
    // Run the validation before sending the data
    if (!validateTaskForm()) {
        return; // Exit if validation fails
    }
    const taskName = document.getElementById("task-name").value;
    const taskStatus = document.getElementById("task-status").value;

    // Use the globally stored currentProjectId instead of accessing arguments
    if (!taskName || !currentProjectId) return;

    await fetch(`${API_BASE_URL}/tasks`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            project_id: currentProjectId,
            name: taskName,
            status: taskStatus,
            description: "",
        }),
    });

    document.getElementById("task-name").value = "";
    loadTasks(currentProjectId);
}

document.addEventListener("DOMContentLoaded", () => {
    loadProjects();

    // Add event listener to the delete button
    document
        .getElementById("delete-project-btn")
        .addEventListener("click", () => {
            if (currentProjectId) {
                deleteProject(currentProjectId);
            }
        });
});

// Function to delete a project
async function deleteProject(projectId) {
    try {
        const response = await fetch(`${API_BASE_URL}/projects/${projectId}`, {
            method: "DELETE",
        });

        if (response.ok) {
            alert("Project deleted successfully!");
            document.getElementById("project-details").style.display = "none";
            loadProjects(); // Reload the project list
        } else {
            alert("Failed to delete the project. Please try again.");
        }
    } catch (error) {
        console.error("Error deleting project:", error);
        alert("An error occurred while trying to delete the project.");
    }
}

// Function to validate the "Add Task" form
function validateTaskForm() {
    const taskName = document.getElementById("task-name").value.trim();
    const taskStatus = document.getElementById("task-status").value;
    let isValid = true;

    // Clear previous error messages
    document.getElementById("task-name-error").textContent = "";
    document.getElementById("task-status-error").textContent = "";

    // Check if the task name is provided
    if (taskName === "") {
        document.getElementById("task-name-error").textContent =
            "Task name is required.";
        isValid = false;
    }

    // Check if the status is selected
    if (taskStatus === "") {
        document.getElementById("task-status-error").textContent =
            "Please select a status for the task.";
        isValid = false;
    }

    return isValid;
}

// Function to validate the "Add Project" form
function validateProjectForm() {
    const projectName = document.getElementById("project-name").value.trim();
    let isValid = true;

    // Clear previous error messages
    document.getElementById("project-name-error").textContent = "";

    // Check if the project name is provided
    if (projectName === "") {
        document.getElementById("project-name-error").textContent =
            "Project name is required.";
        isValid = false;
    }

    return isValid;
}

document.getElementById("filter-button").addEventListener("click", function () {
    const search = document.getElementById("search").value;
    const startDate = document.getElementById("start_date").value;
    const endDate = document.getElementById("end_date").value;

    // Create an array to hold query parameters
    const params = [];

    // Add non-empty parameters to the query string
    if (search) {
        params.push(`search=${encodeURIComponent(search)}`);
    }
    if (startDate) {
        params.push(`start_date=${encodeURIComponent(startDate)}`);
    }
    if (endDate) {
        params.push(`end_date=${encodeURIComponent(endDate)}`);
    }

    // Build the query string
    const queryString = params.length > 0 ? "?" + params.join("&") : "";

    fetch(`${API_BASE_URL}/projects${queryString}`)
        .then((response) => response.json())
        .then((data) => {
            const projectsList = document.getElementById("projects-list");
            projectsList.innerHTML = "";

            data.forEach((project) => {
                const listItem = document.createElement("li");
                listItem.className = "list-group-item list-group-item-action";
                listItem.textContent = project.name;
                listItem.addEventListener("click", () =>
                    loadProjectDetails(project.id)
                );
                projectsList.appendChild(listItem);
            });
        })
        .catch((error) => console.error("Error fetching projects:", error));
});
