# COS-221-Prac5-Winery
## Wine Tourism Platform
![Wine Tourism](wine_tourism_image.jpg)

## Introduction
Tourism has become a significant industry in many countries, contributing to employment, economic growth, and cultural exchange. The South African Government, through the National Department of Tourism, aims to promote South Africa as a destination for tourists interested in wine tastings, considering the country's leadership in wine production. To facilitate tourism within the country and assist tourists in visiting outside destinations, the government has contracted the Global Wine Store (GWS) for a specific project.

The Global Wine Store (GWS) is a worldwide organization that deals with wine production and sales. They are seeking the assistance of a second-year group of students in Computer Science to help implement a wine tourism project. The company already possesses some data that they are currently using. Your task is to design and implement a user-friendly platform for wine tourism, clean and extend the existing data when necessary, and integrate additional data through other APIs or realistic mock data.

The platform should provide users with the ability to view various wines, including their region and other pertinent information. The information should be easily filterable to allow users to find what they are looking for. Users should also be able to view various wineries/wine farms, with relevant information such as location and available wines. Verified wineries should have the ability to add new wines to their catalog. Additionally, the platform should allow users to review wines. Feel free to utilize realistic data, even if it's not provided in the specification.

## Project Specification
For this assignment, you will be using the GWS data provided by the organization to implement your practical assignment. The necessary information to populate the database and implement the project can be found in the following links:

- [Sample APIs - Wines](https://sampleapis.com/wines)
- [Kaggle - Wine Data](https://www.kaggle.com/zynicide/wine-reviews)
- [Kaggle - Wine Reviews](https://www.kaggle.com/zynicide/wine-reviews)
- [UCI Machine Learning Repository - Wine Quality](https://archive.ics.uci.edu/ml/datasets/wine+quality)
- [Global Wine Score API](https://www.globalwinescore.com/)
- [Wine81](https://www.wine81.com/)
- [Data World - Global Wine Points](https://data.world/markpowell/global-wine-points)

## Outcomes
Upon successful completion of this assignment, you should be able to:

- Analyze and understand data from multiple sources.
- Curate the data by cleaning and extending it when necessary.
- Design a database schema to be implemented in a relational database management system (RDBMS) for the curated data.
- Design and build a web-based application that includes:
  - Execution of a connection to an RDBMS from a programming language.
  - Querying and manipulation of a relational database from a programming language.
  - Building a Graphical User Interface (GUI).
  - Utilizing the GUI to query and manipulate a relational database.

## Getting Started
Follow the steps below to set up the Wine Tourism Platform on your local machine:

1. Clone the repository: `git clone https://github.com/your-username/wine-tourism-platform.git`
2. Install the required dependencies: `npm install`
3. Set up the database by executing the SQL scripts provided in the database directory.
4. Update the database connection details in the configuration file `config.js`.
5. Start the application: `npm start`
6. Access the Wine Tourism Platform in your web browser at `http://localhost:3000`.
