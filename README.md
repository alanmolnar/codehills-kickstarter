
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

## 2.0.1
- Added two new commands for creating custom post type and taxonomy
- Updated CustomPostTypes controller, to control only custom post types, taxonomies moved to the new controller
- Added Taxonomies controller
- Fixed PostsGrid class $categories variable warning
- ThemeSetup, Taxonomy class added
- CSS styles for dd() function added back to the main functions file
- Added page header settings to the theme header template part
- Folder /includes moved to the theme root
