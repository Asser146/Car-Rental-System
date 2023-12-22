import os

# Use a relative path to the "assets" folder
assets_folder = 'E:\\xampp\\htdocs\\Labs\\Car Rental System\\assets'
path_to_images = os.path.join(assets_folder, 'Car Images')
output_file_path = 'E:\\xampp\\htdocs\\Labs\\Car Rental System\\output_file.txt'

# Get a list of all image files in the specified directory
image_files = [f for f in os.listdir(path_to_images) if os.path.isfile(os.path.join(path_to_images, f))]

# Open the output file in write mode
with open(output_file_path, 'w') as output_file:
    # Write the header to the file
    output_file.write("Image Name,Path\n")

    # Write image names and paths (starting with "assets\") to the file
    for image_file in image_files:
        relative_path = os.path.relpath(os.path.join(path_to_images, image_file), assets_folder)
        output_file.write(f"{image_file},assets\\{relative_path}\n")

print(f"File '{output_file_path}' has been created.")
