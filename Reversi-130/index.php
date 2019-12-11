<?php session_start(); 

    if( isset($_SESSION['gridSize'])){
        unset($_SESSION['gridSize']);
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

    <link rel="stylesheet" href="assets/css/glider.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/homepage.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <title>Reversi Home Page</title>
</head>
<body>
        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
            <symbol id="icon-creative-commons" viewBox="0 0 20 20">
            <title>creative-commons</title>
            <path d="M7.651 11.628c-0.406 0-0.713-0.148-0.92-0.445-0.209-0.295-0.313-0.689-0.313-1.182 0-1.084 0.41-1.627 1.232-1.627 0.164 0 0.342 0.055 0.533 0.164s0.353 0.301 0.484 0.574l1.232-0.641c-0.492-0.887-1.309-1.33-2.447-1.33-0.778 0-1.422 0.258-1.93 0.771-0.51 0.516-0.766 1.211-0.766 2.088 0 0.898 0.253 1.6 0.756 2.104 0.504 0.504 1.168 0.754 1.988 0.754 0.516 0 0.986-0.129 1.413-0.385 0.427-0.258 0.761-0.611 1.003-1.061l-1.135-0.574c-0.219 0.525-0.597 0.789-1.133 0.789zM12.958 11.628c-0.406 0-0.713-0.148-0.92-0.445-0.209-0.295-0.313-0.689-0.313-1.182 0-1.084 0.41-1.627 1.232-1.627 0.174 0 0.357 0.055 0.549 0.164 0.192 0.109 0.354 0.301 0.486 0.574l1.215-0.641c-0.482-0.887-1.293-1.33-2.432-1.33-0.777 0-1.421 0.258-1.93 0.771-0.51 0.516-0.764 1.211-0.764 2.088 0 0.898 0.248 1.6 0.747 2.104s1.163 0.754 1.996 0.754c0.503 0 0.97-0.129 1.396-0.385 0.428-0.258 0.768-0.611 1.020-1.061l-1.15-0.574c-0.219 0.525-0.598 0.789-1.133 0.789zM16.813 3.184c-1.859-1.856-4.134-2.784-6.825-2.784-2.659 0-4.91 0.927-6.752 2.784-1.89 1.92-2.835 4.192-2.835 6.816s0.945 4.88 2.835 6.768c1.89 1.888 4.141 2.832 6.752 2.832 2.643 0 4.935-0.952 6.873-2.856 1.826-1.808 2.739-4.056 2.739-6.744s-0.929-4.96-2.787-6.816zM15.611 15.496c-1.586 1.568-3.453 2.352-5.6 2.352s-3.997-0.776-5.55-2.328c-1.554-1.551-2.331-3.392-2.331-5.52s0.785-3.984 2.355-5.568c1.506-1.536 3.348-2.304 5.526-2.304s4.029 0.768 5.552 2.304c1.538 1.52 2.307 3.375 2.307 5.568 0 2.208-0.753 4.040-2.259 5.496z"></path>
            </symbol>
            <symbol id="icon-warning" viewBox="0 0 20 20">
            <title>warning</title>
            <path d="M19.511 17.98l-8.907-16.632c-0.124-0.215-0.354-0.348-0.604-0.348s-0.481 0.133-0.604 0.348l-8.906 16.632c-0.121 0.211-0.119 0.471 0.005 0.68 0.125 0.211 0.352 0.34 0.598 0.34h17.814c0.245 0 0.474-0.129 0.598-0.34 0.124-0.209 0.126-0.469 0.006-0.68zM11 17h-2v-2h2v2zM11 13.5h-2v-6.5h2v6.5z"></path>
            </symbol>
            <symbol id="icon-chevron-right" viewBox="0 0 20 20">
            <title>chevron-right</title>
            <path d="M9.163 4.516c0.418 0.408 4.502 4.695 4.502 4.695 0.223 0.219 0.335 0.504 0.335 0.789s-0.112 0.57-0.335 0.787c0 0-4.084 4.289-4.502 4.695-0.418 0.408-1.17 0.436-1.615 0-0.446-0.434-0.481-1.041 0-1.574l3.747-3.908-3.747-3.908c-0.481-0.533-0.446-1.141 0-1.576s1.197-0.409 1.615 0z"></path>
            </symbol>
            <symbol id="icon-trash" viewBox="0 0 20 20">
            <title>trash</title>
            <path d="M3.389 7.113l1.101 10.908c0.061 0.461 2.287 1.977 5.51 1.979 3.225-0.002 5.451-1.518 5.511-1.979l1.102-10.908c-1.684 0.942-4.201 1.387-6.613 1.387-2.41 0-4.928-0.445-6.611-1.387zM13.168 1.51l-0.859-0.951c-0.332-0.473-0.692-0.559-1.393-0.559h-1.831c-0.7 0-1.061 0.086-1.392 0.559l-0.859 0.951c-2.57 0.449-4.434 1.64-4.434 2.519v0.17c0 1.547 3.403 2.801 7.6 2.801 4.198 0 7.601-1.254 7.601-2.801v-0.17c0-0.879-1.863-2.070-4.433-2.519zM12.070 4.34l-1.070-1.34h-2l-1.068 1.34h-1.7c0 0 1.862-2.221 2.111-2.522 0.19-0.23 0.384-0.318 0.636-0.318h2.043c0.253 0 0.447 0.088 0.637 0.318 0.248 0.301 2.111 2.522 2.111 2.522h-1.7z"></path>
            </symbol>
            <symbol id="icon-upload-to-cloud" viewBox="0 0 20 20">
            <title>upload-to-cloud</title>
            <path d="M15.213 6.639c-0.276 0-0.546 0.025-0.809 0.068-0.656-2.145-2.688-3.707-5.095-3.707-2.939 0-5.32 2.328-5.32 5.199 0 0.256 0.020 0.508 0.057 0.756-0.141-0.017-0.283-0.027-0.429-0.027-1.998 0-3.617 1.582-3.617 3.535s1.619 3.537 3.617 3.537h4.383v-4h-2.5l4.5-5 4.5 5h-2.5v4h3.213c2.643 0 4.787-2.096 4.787-4.68 0-2.586-2.144-4.681-4.787-4.681z"></path>
            </symbol>
            <symbol id="icon-beamed-note" viewBox="0 0 20 20">
            <title>beamed-note</title>
            <path d="M17 1l-0.002 13c0 1.243-1.301 3-3.748 3-1.243 0-2.25-0.653-2.25-1.875 0-1.589 1.445-2.55 3-2.55 0.432 0 0.754 0.059 1 0.123v-7.334l-7 1.273v9.363h-0.002c0 1.243-1.301 3-3.748 3-1.243 0-2.25-0.653-2.25-1.875 0-1.589 1.445-2.55 3-2.55 0.432 0 0.754 0.059 1 0.123v-11.698l11-2z"></path>
            </symbol>
            <symbol id="icon-circle-with-cross" viewBox="0 0 20 20">
            <title>circle-with-cross</title>
            <path d="M10 1.6c-4.639 0-8.4 3.761-8.4 8.4s3.761 8.4 8.4 8.4 8.4-3.761 8.4-8.4c0-4.639-3.761-8.4-8.4-8.4zM14.789 13.061l-1.729 1.729-3.060-3.061-3.061 3.060-1.729-1.729 3.062-3.060-3.061-3.061 1.729-1.728 3.060 3.060 3.061-3.061 1.729 1.729-3.062 3.061 3.061 3.061z"></path>
            </symbol>
            <symbol id="icon-circle-with-minus" viewBox="0 0 20 20">
            <title>circle-with-minus</title>
            <path d="M10 1.6c-4.639 0-8.4 3.761-8.4 8.4s3.761 8.4 8.4 8.4 8.4-3.761 8.4-8.4c0-4.639-3.761-8.4-8.4-8.4zM15 11h-10v-2h10v2z"></path>
            </symbol>
            <symbol id="icon-circle-with-plus" viewBox="0 0 20 20">
            <title>circle-with-plus</title>
            <path d="M10 1.6c-4.639 0-8.4 3.761-8.4 8.4s3.761 8.4 8.4 8.4 8.4-3.761 8.4-8.4c0-4.639-3.761-8.4-8.4-8.4zM15 11h-4v4h-2v-4h-4v-2h4v-4h2v4h4v2z"></path>
            </symbol>
            <symbol id="icon-cog" viewBox="0 0 20 20">
            <title>cog</title>
            <path d="M16.783 10c0-1.049 0.646-1.875 1.617-2.443-0.176-0.584-0.407-1.145-0.692-1.672-1.089 0.285-1.97-0.141-2.711-0.883-0.741-0.74-0.968-1.621-0.683-2.711-0.527-0.285-1.088-0.518-1.672-0.691-0.568 0.97-1.595 1.615-2.642 1.615-1.048 0-2.074-0.645-2.643-1.615-0.585 0.173-1.144 0.406-1.671 0.691 0.285 1.090 0.059 1.971-0.684 2.711-0.74 0.742-1.621 1.168-2.711 0.883-0.285 0.527-0.517 1.088-0.691 1.672 0.97 0.568 1.615 1.394 1.615 2.443 0 1.047-0.645 2.074-1.615 2.643 0.175 0.584 0.406 1.144 0.691 1.672 1.090-0.285 1.971-0.059 2.711 0.682s0.969 1.623 0.684 2.711c0.527 0.285 1.087 0.518 1.672 0.693 0.568-0.973 1.595-1.617 2.643-1.617 1.047 0 2.074 0.645 2.643 1.617 0.584-0.176 1.144-0.408 1.672-0.693-0.285-1.088-0.059-1.969 0.683-2.711 0.741-0.74 1.622-1.166 2.711-0.883 0.285-0.527 0.517-1.086 0.692-1.672-0.973-0.569-1.619-1.395-1.619-2.442zM10 13.652c-2.018 0-3.653-1.635-3.653-3.652 0-2.018 1.636-3.654 3.653-3.654s3.652 1.637 3.652 3.654c0 2.018-1.634 3.652-3.652 3.652z"></path>
            </symbol>
            <symbol id="icon-dial-pad" viewBox="0 0 20 20">
            <title>dial-pad</title>
            <path d="M6 0h-2c-0.552 0-1 0.448-1 1v2c0 0.552 0.448 1 1 1h2c0.552 0 1-0.448 1-1v-2c0-0.552-0.448-1-1-1zM11 0h-2c-0.552 0-1 0.448-1 1v2c0 0.552 0.448 1 1 1h2c0.552 0 1-0.448 1-1v-2c0-0.552-0.448-1-1-1zM16 0h-2c-0.552 0-1 0.448-1 1v2c0 0.552 0.448 1 1 1h2c0.552 0 1-0.448 1-1v-2c0-0.552-0.448-1-1-1zM6 5h-2c-0.552 0-1 0.448-1 1v2c0 0.552 0.448 1 1 1h2c0.552 0 1-0.448 1-1v-2c0-0.552-0.448-1-1-1zM11 5h-2c-0.552 0-1 0.448-1 1v2c0 0.552 0.448 1 1 1h2c0.552 0 1-0.448 1-1v-2c0-0.552-0.448-1-1-1zM16 5h-2c-0.552 0-1 0.448-1 1v2c0 0.552 0.448 1 1 1h2c0.552 0 1-0.448 1-1v-2c0-0.552-0.448-1-1-1zM6 10h-2c-0.552 0-1 0.448-1 1v2c0 0.552 0.448 1 1 1h2c0.552 0 1-0.448 1-1v-2c0-0.552-0.448-1-1-1zM11 10h-2c-0.552 0-1 0.448-1 1v2c0 0.552 0.448 1 1 1h2c0.552 0 1-0.448 1-1v-2c0-0.552-0.448-1-1-1zM11 16h-2c-0.552 0-1 0.448-1 1v2c0 0.552 0.448 1 1 1h2c0.552 0 1-0.448 1-1v-2c0-0.552-0.448-1-1-1zM16 10h-2c-0.552 0-1 0.448-1 1v2c0 0.552 0.448 1 1 1h2c0.552 0 1-0.448 1-1v-2c0-0.552-0.448-1-1-1z"></path>
            </symbol>
            <symbol id="icon-graduation-cap" viewBox="0 0 20 20">
            <title>graduation-cap</title>
            <path d="M3.302 12.238c0.464 1.879 1.054 2.701 3.022 3.562 1.969 0.86 2.904 1.8 3.676 1.8s1.648-0.822 3.616-1.684c1.969-0.861 1.443-1.123 1.907-3.002l-5.523 2.686-6.698-3.362zM19.511 7.336l-8.325-4.662c-0.652-0.365-1.72-0.365-2.372 0l-8.326 4.662c-0.652 0.365-0.652 0.963 0 1.328l8.325 4.662c0.652 0.365 1.72 0.365 2.372 0l5.382-3.014-5.836-1.367c-0.225 0.055-0.472 0.086-0.731 0.086-1.052 0-1.904-0.506-1.904-1.131 0-0.627 0.853-1.133 1.904-1.133 0.816 0 1.51 0.307 1.78 0.734l6.182 2.029 1.549-0.867c0.651-0.364 0.651-0.962 0-1.327zM16.967 16.17c-0.065 0.385 1.283 1.018 1.411-0.107 0.579-5.072-0.416-6.531-0.416-6.531l-1.395 0.781c0-0.001 1.183 1.125 0.4 5.857z"></path>
            </symbol>
            <symbol id="icon-heart" viewBox="0 0 20 20">
            <title>heart</title>
            <path d="M17.19 4.155c-1.672-1.534-4.383-1.534-6.055 0l-1.135 1.042-1.136-1.042c-1.672-1.534-4.382-1.534-6.054 0-1.881 1.727-1.881 4.52 0 6.246l7.19 6.599 7.19-6.599c1.88-1.726 1.88-4.52 0-6.246z"></path>
            </symbol>
            <symbol id="icon-home" viewBox="0 0 20 20">
            <title>home</title>
            <path d="M18.672 11h-1.672v6c0 0.445-0.194 1-1 1h-4v-6h-4v6h-4c-0.806 0-1-0.555-1-1v-6h-1.672c-0.598 0-0.47-0.324-0.060-0.748l8.024-8.032c0.195-0.202 0.451-0.302 0.708-0.312 0.257 0.010 0.513 0.109 0.708 0.312l8.023 8.031c0.411 0.425 0.539 0.749-0.059 0.749z"></path>
            </symbol>
            <symbol id="icon-image" viewBox="0 0 20 20">
            <title>image</title>
            <path d="M19 2h-18c-0.553 0-1 0.447-1 1v14c0 0.552 0.447 1 1 1h18c0.553 0 1-0.448 1-1v-14c0-0.552-0.447-1-1-1zM18 16h-16v-12h16v12zM14.315 10.877l-3.231 1.605-3.77-6.101-3.314 7.619h12l-1.685-3.123zM13.25 9c0.69 0 1.25-0.56 1.25-1.25s-0.56-1.25-1.25-1.25-1.25 0.56-1.25 1.25 0.56 1.25 1.25 1.25z"></path>
            </symbol>
            <symbol id="icon-info-with-circle" viewBox="0 0 20 20">
            <title>info-with-circle</title>
            <path d="M10 0.4c-5.303 0-9.601 4.298-9.601 9.6 0 5.303 4.298 9.601 9.601 9.601 5.301 0 9.6-4.298 9.6-9.601s-4.299-9.6-9.6-9.6zM10.896 3.866c0.936 0 1.211 0.543 1.211 1.164 0 0.775-0.62 1.492-1.679 1.492-0.886 0-1.308-0.445-1.282-1.182 0-0.621 0.519-1.474 1.75-1.474zM8.498 15.75c-0.64 0-1.107-0.389-0.66-2.094l0.733-3.025c0.127-0.484 0.148-0.678 0-0.678-0.191 0-1.022 0.334-1.512 0.664l-0.319-0.523c1.555-1.299 3.343-2.061 4.108-2.061 0.64 0 0.746 0.756 0.427 1.92l-0.84 3.18c-0.149 0.562-0.085 0.756 0.064 0.756 0.192 0 0.82-0.232 1.438-0.719l0.362 0.486c-1.513 1.512-3.162 2.094-3.801 2.094z"></path>
            </symbol>
            <symbol id="icon-laptop" viewBox="0 0 20 20">
            <title>laptop</title>
            <path d="M19.754 15.631c-0.247-0.371-1.754-2.631-1.754-2.631v-9c0-1.102-0.9-2-2-2h-12c-1.101 0-2 0.898-2 2v9c0 0-1.507 2.26-1.754 2.631-0.246 0.369-0.246 0.582-0.246 0.869v0.5c0 0.5 0.5 1 0.999 1h18.002c0.499 0 0.999-0.5 0.999-1v-0.5c0-0.287 0-0.5-0.246-0.869zM7 16l0.6-1h4.8l0.6 1h-6zM16 12h-12v-8h12v8z"></path>
            </symbol>
            <symbol id="icon-magnifying-glass" viewBox="0 0 20 20">
            <title>magnifying-glass</title>
            <path d="M17.545 15.467l-3.779-3.779c0.57-0.935 0.898-2.035 0.898-3.21 0-3.417-2.961-6.377-6.378-6.377s-6.186 2.769-6.186 6.186c0 3.416 2.961 6.377 6.377 6.377 1.137 0 2.2-0.309 3.115-0.844l3.799 3.801c0.372 0.371 0.975 0.371 1.346 0l0.943-0.943c0.371-0.371 0.236-0.84-0.135-1.211zM4.004 8.287c0-2.366 1.917-4.283 4.282-4.283s4.474 2.107 4.474 4.474c0 2.365-1.918 4.283-4.283 4.283s-4.473-2.109-4.473-4.474z"></path>
            </symbol>
            <symbol id="icon-rocket" viewBox="0 0 20 20">
            <title>rocket</title>
            <path d="M11.933 13.069c0 0 7.059-5.094 6.276-10.924-0.017-0.127-0.059-0.213-0.112-0.268-0.054-0.055-0.137-0.098-0.263-0.115-5.697-0.801-10.674 6.422-10.674 6.422-4.318-0.517-4.004 0.344-5.974 5.076-0.377 0.902 0.234 1.213 0.904 0.959 0.67-0.252 2.148-0.811 2.148-0.811l2.59 2.648c0 0-0.546 1.514-0.793 2.199s0.055 1.311 0.938 0.926c4.624-2.016 5.466-1.694 4.96-6.112zM12.942 7.153c-0.598-0.613-0.598-1.604 0-2.217 0.598-0.611 1.567-0.611 2.166 0s0.598 1.603 0 2.217c-0.599 0.611-1.569 0.611-2.166 0z"></path>
            </symbol>
            <symbol id="icon-star" viewBox="0 0 20 20">
            <title>star</title>
            <path d="M10 1.3l2.388 6.722h6.412l-5.232 3.948 1.871 6.928-5.439-4.154-5.438 4.154 1.87-6.928-5.233-3.948h6.412l2.389-6.722z"></path>
            </symbol>
            <symbol id="icon-thumbs-down" viewBox="0 0 20 20">
            <title>thumbs-down</title>
            <path d="M6.352 12.638c0.133 0.356-3.539 3.634-1.397 6.291 0.501 0.621 2.201-2.975 4.615-4.602 1.331-0.899 4.43-2.811 4.43-3.868v-6.842c0-1.271-4.914-2.617-8.648-2.617-1.369 0-3.352 8.576-3.352 9.939 0 1.367 4.221 1.343 4.352 1.699zM15 12.543c0.658 0 3-0.4 3-3.123v-4.848c0-2.721-2.342-3.021-3-3.021-0.657 0 1 0.572 1 2.26v6.373c0 1.768-1.657 2.359-1 2.359z"></path>
            </symbol>
            <symbol id="icon-thumbs-up" viewBox="0 0 20 20">
            <title>thumbs-up</title>
            <path d="M13.648 7.362c-0.133-0.355 3.539-3.634 1.398-6.291-0.501-0.621-2.201 2.975-4.615 4.603-1.332 0.898-4.431 2.81-4.431 3.867v6.842c0 1.271 4.914 2.617 8.648 2.617 1.369 0 3.352-8.576 3.352-9.938 0-1.368-4.221-1.344-4.352-1.7zM5 7.457c-0.658 0-3 0.4-3 3.123v4.848c0 2.721 2.342 3.021 3 3.021 0.657 0-1-0.572-1-2.26v-6.373c0-1.768 1.657-2.359 1-2.359z"></path>
            </symbol>
            <symbol id="icon-tools" viewBox="0 0 20 20">
            <title>tools</title>
            <path d="M3.135 6.89c0.933-0.725 1.707-0.225 2.74 0.971 0.116 0.135 0.272-0.023 0.361-0.1 0.088-0.078 1.451-1.305 1.518-1.361 0.066-0.059 0.146-0.169 0.041-0.292-0.107-0.123-0.494-0.625-0.743-0.951-1.808-2.365 4.946-3.969 3.909-3.994-0.528-0.014-2.646-0.039-2.963-0.004-1.283 0.135-2.894 1.334-3.705 1.893-1.061 0.726-1.457 1.152-1.522 1.211-0.3 0.262-0.048 0.867-0.592 1.344-0.575 0.503-0.934 0.122-1.267 0.414-0.165 0.146-0.627 0.492-0.759 0.607-0.133 0.117-0.157 0.314-0.021 0.471 0 0 1.264 1.396 1.37 1.52 0.105 0.122 0.391 0.228 0.567 0.071 0.177-0.156 0.632-0.553 0.708-0.623 0.078-0.066-0.050-0.861 0.358-1.177zM8.843 7.407c-0.12-0.139-0.269-0.143-0.397-0.029l-1.434 1.252c-0.113 0.1-0.129 0.283-0.027 0.4l8.294 9.439c0.194 0.223 0.53 0.246 0.751 0.053l0.97-0.813c0.222-0.195 0.245-0.533 0.052-0.758l-8.209-9.544zM19.902 3.39c-0.074-0.494-0.33-0.391-0.463-0.182-0.133 0.211-0.721 1.102-0.963 1.506-0.24 0.4-0.832 1.191-1.934 0.41-1.148-0.811-0.749-1.377-0.549-1.758 0.201-0.383 0.818-1.457 0.907-1.59 0.089-0.135-0.015-0.527-0.371-0.363s-2.523 1.025-2.823 2.26c-0.307 1.256 0.257 2.379-0.85 3.494l-1.343 1.4 1.349 1.566 1.654-1.57c0.394-0.396 1.236-0.781 1.998-0.607 1.633 0.369 2.524-0.244 3.061-1.258 0.482-0.906 0.402-2.814 0.327-3.308zM2.739 17.053c-0.208 0.209-0.208 0.549 0 0.758l0.951 0.93c0.208 0.209 0.538 0.121 0.746-0.088l4.907-4.824-1.503-1.714-5.101 4.938z"></path>
            </symbol>
            <symbol id="icon-user" viewBox="0 0 20 20">
            <title>user</title>
            <path d="M7.725 2.146c-1.016 0.756-1.289 1.953-1.239 2.59 0.064 0.779 0.222 1.793 0.222 1.793s-0.313 0.17-0.313 0.854c0.109 1.717 0.683 0.976 0.801 1.729 0.284 1.814 0.933 1.491 0.933 2.481 0 1.649-0.68 2.42-2.803 3.334-2.13 0.918-4.326 2.073-4.326 4.073v1h18v-1c0-2-2.197-3.155-4.328-4.072-2.123-0.914-2.801-1.684-2.801-3.334 0-0.99 0.647-0.667 0.932-2.481 0.119-0.753 0.692-0.012 0.803-1.729 0-0.684-0.314-0.854-0.314-0.854s0.158-1.014 0.221-1.793c0.065-0.817-0.398-2.561-2.3-3.096-0.333-0.34-0.558-0.881 0.466-1.424-2.24-0.105-2.761 1.067-3.954 1.929z"></path>
            </symbol>
            </defs>
            </svg>
    <div class="header_nav">
        <div class="header_link">
            <a href="reversiGame.php">Reversi!</a><!--this will take you back to the home screen-->
        </div>
        <div class="header_link">
            <a href="about_page.php">About</a><!--this will bring up pages about the game and or authors james and miklo-->
        </div>
        <div class="header_link">
            <a href="howto_page.php">How to Play</a><!--add the wikipedia website for the how to play-->
       <!--maybe actually make an about page and put the wikipedia link in there and a helpful youtube video-->
        </div>
        <?php if(!isset($_SESSION['email'])){ ?>
            <div class="header_link">
                <a href="assets\login\login_mysql.php">LogIn</a><!--this will bring up pages about the game and or authors james and miklo-->
            </div>
            <div class="header_link">
                <a href="assets\login\register_mysql.php">SignUp</a><!--this will bring up pages about the game and or authors james and miklo-->
            </div>

        <?php } else { ?>
            <div class="header_link">
                <a> Hello <?php echo $_SESSION['email'] ?></a><!--this will bring up pages about the game and or authors james and miklo-->
            </div>
            <div class="header_link">
                <a href="assets\login\logout_mysql.php">LogOut</a><!--this will bring up pages about the game and or authors james and miklo-->
            </div>
        <?php } ?>
        
    </div>

    <div class="glider-container multiple">
        <h1 class="usertest">Welcome to Our Reversi Pub</h1>
        <button class="glider-prev">
            <i class="fa fa-chevron-left"></i>
        </button>
        <div class="glider">
            <figure class="glider-fig">
                <p class="glider-text">
                    Want to Play some Reversi <br>Hit the Reversi button...
                </p>
                
            </figure>
            <figure class="glider-fig">
                <p class="glider-text">
                    Don't Know how to play? <br>Dont be afraid check out our How To page!
                </p>
                
            </figure>
            <figure class="glider-fig">
                <p class="glider-text">
                    Explore <span style="font-weight: 700;">Our</span> site <br>Meet the Devlopers on the <span style="font-weight: 700;">About</span> Page!
                </p>
            </figure>
        </div>
        <button class="glider-next">
            <i class="fa fa-chevron-right"></i>
        </button>
        <div id="dots" class="glider-dots"></div>
    </div>
    <div class="section_1">
        <div class="section_1_box_1">
                <div class="text_box_greetings">
                    Welcome Traveler to our Game Pub!
                </div>
                <div class="text_box_1">
                     So, what brings you here traveler?<br>
                     Want to Play some reversi I see...<br>
                     Well please, take a load off and lets get the game started! <br>
                     But before we get started be sure that you know the rules of the game! <br>
                     But dont freit, if you do not know the rules please take a look at the pubs <span>How To</span> page <br>
                     Now with nothing left to say, Hope you have fun...
                </div>
        </div>
        <div class="section_1_box_2">
            <img class="tavern" src="assets/img/tavern.jpg" alt="tavern guy" style="width: 200px; height: 200px; border-radius: 110px;">
        </div>
    </div>
    
    <div class="slogans">
            <div class="core_capsule">
                <div class="core_title">
                    <p>
                        Want To Start Playing!
                    </p>
                </div>
                <div class="cores">
                    <div class="cores_content">
                        <p class="title">Slown down there Buckeroo! Take these into consideration</p>
                        <p><span class="cores_num">1.</span> Do You Know Hot to Play the Game</p>
                        <p><span class="cores_num">2.</span> Do YOu Have an Account?</p>
                        <p><span class="cores_num">3.</span> Have You Met the Devs Yet.. Go show'em some love</p>
                        <p><span class="cores_num">4.</span> Most Important do you have INTERNET CONNECTION</p>
                        <p class="caption">...Green Light Go!</p>
                    </div>
                </div>
            </div>
            <div class="core_capsule">
                <div class="core_title">
                    <p>
                        Don't Have an Account Yet!
                    </p>
                </div>
                <div class="cores">
                    <div class="cores_content">
                        <p class="title">Lets Get you An Account</p>
                        <p><span class="cores_num"><svg><use xlink:href="#icon-chevron-right"></use></svg></span> Go and hit that SignUp link above or below</p>
                        <p><span class="cores_num"><svg><use xlink:href="#icon-chevron-right"></use></svg></span> Have an account alread? Then hurry up and Log in!</p>
                        <p class="caption">
                                <a href="assets\login\register_mysql.php" class="signc_button">
                                    Signup
                                </a>
                            </p>
                    </div>
                </div>
            </div>
            <div class="core_capsule">
                <div class="core_title">
                    <p>
                        Don't Know How to Play? 
                    </p>
                </div>
                <div class="cores">
                    <div class="cores_content">
                        <p class="title">No Worries!</p>
                        <p><span class="cores_num"><svg><use xlink:href="#icon-chevron-right"></use></svg></span> Hit the HowTo link above!</p>
                        <p><span class="cores_num"><svg><use xlink:href="#icon-chevron-right"></use></svg></span> Read the artcles and if you want watch the helpful video</p>
                        
                        
                    </div>
                </div>
            </div>
            <div class="core_capsule">
                    <div class="core_title">
                        <p>
                            Have You met the Devs? 
                        </p>
                    </div>
                    <div class="cores">
                        <div class="cores_content">
                            <p class="title">Go and See Them</p>
                            <p><span class="cores_num"><svg><use xlink:href="#icon-chevron-right"></use></svg></span> They worked really hard to get this project to you!</p>
                            <p><span class="cores_num"><svg><use xlink:href="#icon-chevron-right"></use></svg></span> Pretty sure one of them shaved a year off his life due to stress...</p>
                            <p><span class="cores_num"><svg><use xlink:href="#icon-chevron-right"></use></svg></span> *cough*.. go support our patreon..*cough*</p>
                                
                        </div>
                    </div>
                </div>
        </div>


    <div class="foot_container">
        <footer class="foot_capsule">
            <div class="foot_left">
                <div class="foot_title">
                    <div class="foot_title_name">
                        <p>Tavern Pub</p>
                    </div>
                    <div class="foot_title_img">
                        <img src="assets/img/logo1.svg" alt="logo" class="logo1" style="width: 50px; height: 50px;">
                    </div>
                </div>
                <div class="foot_copy">
                    <span class="copyR">
                        Copyright
                    </span>
                    <div class="foot_copy_svg">
                            <svg><use xlink:href="#icon-creative-commons"></use></svg>
                    </div>
                    <span class="copyR">
                        2019 Tavern Pub, Inc.
                    </span>
                </div>
            </div>
            <div class="foot_right">
                <div class="foot_link">
                    <a href="#">Terms & Conditions</a>
                </div>
                <div class="foot_link">
                    <a href="#">Privacy Policy</a>
                </div>
                <div class="foot_link">
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </footer>
    </div>



<script src="assets/glider.min.js"></script>
<script>
    new Glider(document.querySelector('.glider'), {
        slidesToShow: 1,
        draggable: true,
        dots: '#dots',
        scrollLockDelay: 250,
        rewind: true,
        arrows: {
            prev: '.glider-prev',
            next: '.glider-next'
        }
    });
</script>

</body>
</html>