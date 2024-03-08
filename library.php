<?php
include 'settings/connection.php';
function display_categories($userID)
{

  $db = $GLOBALS['db'];
  $result = $db->query("SELECT Category FROM Categories 
  JOIN UserCategories ON Categories.CategoryID = UserCategories.CategoryID 
  WHERE UserCategories.UserID = " . $userID . ";"); //placeholder, should use person logged in's categories

  if (!$result) {
    die("Query failed: " . $db->error);
  }

  $categories = $result->fetch_all(MYSQLI_ASSOC);

  foreach ($categories as $category) {
    echo ' <a href="#" class="list-group-item list-group-item-action">' . $category['Category'] . '</a>';
  }
}

function display_books($userID)
{
  $db = $GLOBALS['db'];
  $result = $db->query("SELECT Books.* FROM Books 
  JOIN UserBooks ON Books.BookID = UserBooks.BookID 
  WHERE UserBooks.UserID = " . $userID. " ;");

  // Check if there are any books
  if ($result->num_rows > 0) {
    // Output each book
    while ($row = $result->fetch_assoc()) {
      echo '<div class="col-md-3">
              <div class="card">
                  <img src="' . $row['Cover'] . '" class="card-img-top" alt="Book Image" />
                  <div class="card-body">
                      <h5 class="card-title">' . $row['Title'] . '</h5>
                  </div>
              </div>
          </div>';
    }
  } else {
    echo "No books found.";
  }
}


?>

<!DOCTYPE html>
<html>

<head>
  <title>Library Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <style>
    .offcanvas {
      width: 350px !important;
    }

    .offcanvas .list-group-item {
      border: none;
    }

    #side-bar-options {
      padding: 0.7rem 2rem;
      /* Increase thickness of <li> */
    }

    .card-title {
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      font-size: 18px;
    }

    .col-md-3 {
      margin-bottom: 20px;
      /* Adjust this value to increase or decrease the space */
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
    <button class="btn me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand mr-3" href="#">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
        <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
      </svg>
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav w-100 d-flex justify-content-center align-items-center">
        <li class="nav-item me-3">
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search your library" aria-label="Search" />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>
          </form>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
              </svg>
            </i>
            Sort by
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Title</a></li>
            <li><a class="dropdown-item" href="#">Author</a></li>
            <li><a class="dropdown-item" href="#">Recent</a></li>
          </ul>
        </li>
      </ul>
      <div class="nav-item ms-3">
        <a class="nav-link" href="#">
          <i>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
            </svg>
          </i>
        </a>
      </div>
    </div>
  </nav>

  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasSidebarLabel">
        Book Catalogue
      </h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="side-bar">
      <ul class="list-group list-group-flush">
        <li>
          <a href="dashboard.php" class="list-group-item list-group-item-action align-items-center" id="side-bar-options">
            <svg class="me-auto" width="24" height="24">
              <!--svg -->
            </svg>
            <span class="las la-book"></span> Dashboard
          </a>
        </li>
        <li>
          <a href="library.php" class="list-group-item list-group-item-action align-items-center" id="side-bar-options">
            <svg class="me-auto" width="24" height="24">
              <!-- svg -->
            </svg>
            <span class="las la-book"></span> Book Catalogue
          </a>
        </li>
        <li>
          <a href="#" class="list-group-item list-group-item-action align-items-center" id="side-bar-options">
            <svg class="me-auto" width="24" height="24">
              <!-- svg -->
            </svg>
            <span class="las la-book-reader"></span> Reading Goals
          </a>
        </li>
        <li>
          <a href="#" class="list-group-item list-group-item-action align-items-center" id="side-bar-options">
            <svg class="me-auto" width="24" height="24">
              <!-- svg -->
            </svg>
            <span class="las la-medal"></span> Competitions
          </a>
        </li>
        <li>
          <a href="search.php" class="list-group-item list-group-item-action align-items-center" id="side-bar-options">
            <svg class="me-auto" width="24" height="24">
              <!--svg -->
            </svg>
            <span class="las la-search"></span> Search
          </a>
        </li>
        <li>
          <a href="discover.php" class="list-group-item list-group-item-action align-items-center" id="side-bar-options">
            <svg class="me-auto" width="24" height="24">
              <!-- svg -->
            </svg>
            <span class="las la-compass"></span> Discover
          </a>
        </li>
        <li>
          <a href="#" class="list-group-item list-group-item-action align-items-center" id="side-bar-options">
            <svg class="me-auto" width="24" height="24">
              <!--svg-->
            </svg>
            <span class="las la-user"></span> Profile
          </a>
        </li>
        <li>
          <a href="login.php" class="list-group-item list-group-item-action align-items-center" id="side-bar-options">
            <svg class="me-auto" width="24" height="24">
              <!-- svg -->
            </svg>
            <span class="las la-sign-out-alt"></span> Sign out
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="container-fluid mt-3">
    <div class="row">
      <div class="col-md-3">
        <h4>Library</h4>
        <div id="side-bar" class="list-group">
          <?= display_categories(1); ?>
          <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            Add
            <i style="margin-left: 230px">
              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="black" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
              </svg>
            </i>
          </a>

        </div>
      </div>
      <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addCategoryModalLabel">Add Category Name</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="text" class="form-control" placeholder="Category Name">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Okay</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="row">
          <?= display_books(1); ?>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>





</body>

</html>