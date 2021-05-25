# Selenium-driven program to pull the daily menus from Nutrition.nd.edu.
# Because campus dining wouldn't give us their PUBLIC data, we took it.

# Imports
import sys
import os
import time
import string
import csv
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC 
from bs4 import BeautifulSoup
from selenium.webdriver.firefox.options import Options
from selenium.webdriver.common.action_chains import ActionChains

# Globals
url  = 'http://nutrition.nd.edu/NetNutrition/1'
path = 'geckodriver'

class foodScraper():
    def __init__(self):
        
        options = Options()
        options.add_argument('--headless')
        options.add_argument('--disable-gpu')  
        self.driver = webdriver.Firefox(executable_path=path, options=options)

        #self.driver = webdriver.Chrome(executable_path=path)
        self.driver.get(url)
        self.north_file = open('todayNorth.csv', 'w', newline='')
        self.north_writer = csv.writer(self.north_file, delimiter=',', quotechar='"', quoting=csv.QUOTE_MINIMAL)
        self.south_file = open('todaySouth.csv', 'w', newline='')
        self.south_writer = csv.writer(self.south_file, delimiter=',', quotechar='"', quoting=csv.QUOTE_MINIMAL)

    # Cycle through both dining halls
    def cycleLocations(self):
        gotoNorth = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.XPATH, '//*[@id="unitsPanel"]/section/table/tbody/tr[2]/td/div/table/tbody/tr[1]/td/a'))).click()
        self.navigate(1)

        gotoSouth = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.XPATH, '//*[@id="unitsPanel"]/section/table/tbody/tr[5]/td/div/table/tbody/tr[1]/td/a'))).click()
        self.navigate(2)

    # Cycle through meals on the current day for a particular dining hall
    def navigate(self, location):
        gotoMenus = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.XPATH, '//*[@id="childUnitsPanel"]/section/table/tbody/tr/td[1]/a'))).click()

        gotoBreakfast = WebDriverWait(self.driver, 10).until(EC.visibility_of_element_located((By.XPATH, '//*[@id="MenuList"]/div[2]/table/tbody/tr[2]/td/table/tbody/tr[2]/td/table/tbody/tr/td[1]/a')))
        self.driver.execute_script("arguments[0].scrollIntoView();", gotoBreakfast)
        ActionChains(self.driver).move_to_element(gotoBreakfast).click().perform()
        self.scrapeFood(location)
        #print("Breakfast done")
        gotoLunch = WebDriverWait(self.driver, 10).until(EC.visibility_of_element_located((By.XPATH, '//*[@id="MenuList"]/div[2]/table/tbody/tr[2]/td/table/tbody/tr[2]/td/table/tbody/tr/td[2]/a')))
        self.driver.execute_script("arguments[0].scrollIntoView();", gotoLunch)
        ActionChains(self.driver).move_to_element(gotoLunch).click().perform()
        self.scrapeFood(location)
        #print("Lunch done")
        gotoDinner = WebDriverWait(self.driver, 10).until(EC.visibility_of_element_located((By.XPATH, '//*[@id="MenuList"]/div[2]/table/tbody/tr[2]/td/table/tbody/tr[2]/td/table/tbody/tr/td[3]/a')))
        self.driver.execute_script("arguments[0].scrollIntoView();", gotoDinner)
        ActionChains(self.driver).move_to_element(gotoDinner).click().perform()
        self.scrapeFood(location)
        #print("Dinner done")
        self.returnToLocations()
    
    # Quick function to return to page of the locations
    def returnToLocations(self):
        back1 = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.ID, 'btn_BackmenuList1'))).click() 
        back2 = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.ID, 'btn_Back*Child Units'))).click()

    # Pull food data from a particular meal at a particular dining hall on the current day
    def scrapeFood(self, location):
        backButton = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.ID, 'btn_Back1')))
        nutritionButton = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.ID, 'detail1'))) 
        
        # Click all food checkboxes
        foodChecks = self.driver.find_elements(by=By.CSS_SELECTOR, value=("input[id^='cbm']"))
        for c in foodChecks:
            if not c.is_selected():
                c.click()
        
        # Press nutrition
        nutritionButton.click()
        time.sleep(0.5) 
        
        # TODO: Scrape nutrition data
        nutritionTable = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.XPATH, '//*[@id="nutritionGrid"]/div[2]/table/tbody')))
        html = nutritionTable.get_attribute('innerHTML')
        soup = BeautifulSoup(html, 'html.parser')
        rows = soup.find_all('tr', class_='cbo_nn_NutritionGridDetailRow')

        # Elements 0 (name), 1 (cals), 3 (fat g), 14 (carbs g), 18 (sugar g), 19 (protein g)
        for row in rows:
            cols = row.find_all('td')
            cols = [ele.text.strip() for ele in cols]

            # Grab food info
            fields = cols[0].split('\xa0-\xa0\xa0')
            name_raw = fields[0]
            name = name_raw.replace("'", "")
            serving = fields[1].split('\xa0\xa0(')[0]
            calories = cols[1]
            fat      = cols[3]
            carbs    = cols[14]
            sugar    = cols[18]
            protein  = cols[19]

            # Append to CSV
            if location == 1:
                self.north_writer.writerow([name, serving, calories, fat, carbs, sugar, protein])
            elif location == 2:
                self.south_writer.writerow([name, serving, calories, fat, carbs, sugar, protein])
            
        # Close and go to next meal
        if location == 1:
            self.north_writer.writerow(['-', '-', '-', '-', '-', '-', '-'])
        elif location == 2:
            self.south_writer.writerow(['-', '-', '-', '-', '-', '-', '-'])

        closeButton = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.ID, 'btn_nn_grid_close')))
        closeButton.click()
        backButton.click()

def main():
    bot = foodScraper()
    bot.cycleLocations()
    
if __name__ == "__main__":
    main()
