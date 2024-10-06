# Use the official Nginx image to serve the static files
FROM nginx:latest

# Copy the frontend folder to the Nginx root directory
COPY frontend /usr/share/nginx/html

# Expose port 80
EXPOSE 80
