<div id="top"></div>


<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/Phoenix-VTC/base">
    <img src="https://base.phoenixvtc.com/img/logo.png" alt="Phoenix Logo" height="100">
  </a>

<h3 align="center">PhoenixBase</h3>

  <p align="center">
    <a href="https://base.phoenixvtc.com"><strong>Production Domain »</strong></a>
    <br />
    <br />
    <a href="https://base-staging.phoenixvtc.com">Staging Domain</a>
    ·
    <a href="https://app.shortcut.com/phoenixvtc">Project Management Board</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#contributing">Contributing</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

[![PhoenixBase screenshot][product-screenshot]](https://example.com)

<p align="right">(<a href="#top">back to top</a>)</p>



### Built With

* [Laravel 8.x](https://laravel.com)
* [Laravel Livewire 2.x](https://laravel-livewire.com)
* [Alpine.js 3.x](https://alpinejs.dev)
* [Tailwind CSS 2.x](https://tailwindcss.com)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running, follow these simple steps.

### Prerequisites

This project locally runs on Docker with Laravel Sail. If you haven't yet, make sure to install Docker first.

The below installation instructions expect you to have created a bash alias for Sail. If you haven't done this yet, [the Sail documentation](https://laravel.com/docs/8.x/sail#configuring-a-bash-alias) explains how.

### Installation

1. Clone the repo

   ```sh
   git clone git@github.com:Phoenix-VTC/base.git
   ```

2. CD into the project directory

   ```sh
   cd base
   ```
   
3. Copy the .env file and enter the required information

    ```sh
    cp .env.example .env

    nano .env
    ```

4. Install the composer dependencies by starting a small, temporary Docker container

    ```sh
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php80-composer:latest \
        composer install --ignore-platform-reqs
    ```   
   
5. Start the Sail container

   ```sh
   sail up -d
   ```  
   
6. Generate an application key, and migrate & seed the database

    ```sh
    sail artisan key:generate
    sail artisan migrate --seed 
    ```     
   
7. Add the `APP_URL`, `APPLY_URL` and `EVENTS_URL` values from your .env file to your hosts file

    ```sh
    127.0.0.1      base.test
    127.0.0.1      apply.base.test
    127.0.0.1      events.base.test
    ```   
   
8. Install the NPM packages

   ```sh
   sail npm install
   ```   
   
9. Compile the assets

   ```sh
   sail npm run development
   ```

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## Contributing

**When choosing a branch name, always use the Git Helper generated value from Shortcut.com. E.g. `feature/sc-123-some-cool-features`.**  
**When writing commit messages, always include the ticket number at the end. E.g. `Add some cool feature [sc-123]`.**

**Your commit messages should also always use the past tense, since they describe what the change will do.**  
Valid: "Rename foo to bar"  
Invalid: "Renamed foo to bar"

**Your pull request names should always use the Git Helper generated commit message value from Shortcut.com. E.g. `Add some cool feature [sc-123]`.**

1. Clone the Project
2. Create your branch (`git checkout -b feature/sc-123-some-cool-feature`)
3. Commit your changes (`git commit -m 'Add some cool feature [sc-123]'`)
4. Push to the branch (`git push origin feature/sc-123-some-cool-feature`)
5. Open a pull request, and wait for it to be reviewed by another team member 

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
[product-screenshot]: https://i.imgur.com/fL34tdE.png
