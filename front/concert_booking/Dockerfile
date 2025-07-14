FROM node:18-alpine

# Set working directory
WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy source code
COPY . .

# Build the application
RUN npm run build

# Install serve to run the application
RUN npm install -g @angular/cli

# Expose port 4200
EXPOSE 4200

# Start the application
CMD ["ng", "serve", "--host", "0.0.0.0", "--port", "4200"]
