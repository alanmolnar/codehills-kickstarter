
# Theme Installation Guide

To install the theme, you have two ways:

## Using a URL
Visit the specified resource page, enter the provided password, and download the theme file. Once you downloaded the file, use one of two methods to install the theme.

### Method 1: Upload Through WordPress Backend
1. Log in to your WordPress admin dashboard.
2. Navigate to **Appearance > Themes**.
3. Click on the **Add New** button.
4. Click on the **Upload Theme** button at the top.
5. Choose your theme's `.zip` file from your computer.
6. Click **Install Now** and then activate the theme.

### Method 2: Extract Files in `/themes` Folder
1. Download the theme's `.zip` file to your computer.
2. Navigate to the `/wp-content/themes` directory.
3. Extract the contents of the `.zip` file.
4. Go to your WordPress admin dashboard and activate the theme under **Appearance > Themes**.

## Using GitHub
To clone a repository directly from GitHub, you can use the `git clone` command in your terminal or command line interface. Here are the steps to do this:

1. Ensure Git is installed on your machine. You can check this by running `git --version`. If it's not installed, download and install it from [git-scm.com](https://git-scm.com).
2. Open your terminal or command prompt.
3. Navigate to the directory where you want to store the cloned repository. Use the `cd` command to change directories. For example:
   ```bash
   cd /path/to/your/directory
   ```
4. Copy the repository URL from GitHub. You can find this URL by going to the GitHub repository page you want to clone, and clicking the **Code** button. Select the HTTPS link (it looks like `https://github.com/your-username/repository-name.git`).
5. Run the `git clone` command followed by the repository URL. For example:
   ```bash
   git clone https://github.com/alanmolnar/codehills-kickstarter
   ```
6. Press Enter. Git will create a directory named after the repository in your current location, download all the repository's files, and set up the necessary Git structures for version control.

You have successfully cloned the repository to your local machine. You can now navigate into the repository's directory and start working with the files.

# Changelog

## 2.1.1 - Jan 20th, 2025
- Updated template selector for archive page, to include all kind of post types and WooCommerce
- Updated ACF group 'Page Builder', added 'Block Elements Switcher' clone fields to the FAQ and Testimonial flexible layout
- Added ACF group 'Block Elements Switcher' to be used in blocks with global content
- Updated FAQ and Testimonials block classes to use new 'Block Elements Switcher' cloned field
- Added index.php in theme root

## 2.1.0 - Jan 20th, 2025
- Twig templating system added
- WordPress template hierarchy customized, selection between Twig and PHP templating system added

## 2.0.2 - Jan 13th, 2025
- Fixed 'disable_block' flag in Builder controller
- Updated Builder class method get_ctas() with the $ctas parameter to support manual call for the block
- Added titles order to the block titles template part
- Updated headers in typo.css with theme primary font family and weight 700
- Updated style.css html font family with theme primary font family, removed 'sans-serif'
- Added function has_block( $block_name ) to the Builder controller
- Folder names updated to fix error when website is moved to the web server (capitalized folder names) both in folder structure and in the controllers
- Social links template part created and footer.php updated
- Added two commands to the console.sh
- Updated Block Global Settings JSON with allow_null = 1 for title and subtitle tag and style dropdowns

## 2.0.1 - Dec 17th, 2024
- Added two new commands for creating custom post type and taxonomy
- Updated CustomPostTypes controller, to control only custom post types, taxonomies moved to the new controller
- Added Taxonomies controller
- Fixed PostsGrid class $categories variable warning
- ThemeSetup, Taxonomy class added
- CSS styles for dd() function added back to the main functions file
- Added page header settings to the theme header template part
- Folder /includes moved to the theme root
