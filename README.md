# sign-up-training (aka edzesre-jottem)
Simple "sign up" for saving name of attendee into Google Spreadsheet

## Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Google Speadsheet API](#google-spreasheet-api)

## Requirements

- Docker (for containerization)
- Docker Compose (for managing multi-container Docker applications)
- You must [prepare a spreadsheet](#setting-up-google-sheets-api) and set .env configuration.
	
## Installation

1. Clone repository!
2. Customize ```.env``` file based on ```.env.example```
3. Set schedule in ```resources/schedule.json```
4. Build and run the image
	```batch
	docker-compose up -d --build
	```

## Google Spreadsheet API

#### Setting Up Google Sheets API

To connect to a spreadsheet, you will need to enable the Google Sheets API. Follow these steps:

1. Log in to the [Google Cloud Console](https://console.cloud.google.com/) and create a new project.
2. Enable the Google Sheets API for your project.
3. Create a Service Account and download the JSON key.
4. Share your spreadsheet with the Service Account's email address (you can find it in the JSON key) to grant it write access.

---