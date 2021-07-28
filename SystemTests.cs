using NUnit.Framework;
using OpenQA.Selenium;
using OpenQA.Selenium.Firefox;
using OpenQA.Selenium.Support.Events;
using OpenQA.Selenium.Support.UI;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading;

namespace projekt_2_System_tests
{
    class WebSiteTestsBase
    {
        IWebDriver driver;
        readonly string APP_URL = "https://ux.up.krakow.pl/~golluk/mathBoard/";
        private static readonly Random randomGenerator = new Random();

        [SetUp]
        public void Initialize()
        {
            driver = new FirefoxDriver();
        }

        [Test]
        public void CopyrightFooterIsPresentAndUptodate()
        {
            string COPYRIGHT_HEADER_TEMPLATE = "© {0} Łukasz Golonka, sources are available on GitHub";
            driver.Url = APP_URL;
            IReadOnlyCollection<IWebElement> navLinks = driver.FindElements(By.ClassName("nav-link"));
            int navLinksCount = navLinks.Count;
            Assert.AreEqual(4, navLinksCount);
            for (int currLinkIndex = 0; currLinkIndex < navLinksCount; currLinkIndex++)
            {
                driver.FindElements(By.ClassName("nav-link"))[currLinkIndex].Click();
                string copyrightFooterText = driver.FindElement(By.TagName("footer")).Text;
                Assert.AreEqual(String.Format(COPYRIGHT_HEADER_TEMPLATE, DateTime.Now.Year.ToString()), copyrightFooterText);
                Thread.Sleep(10000);
            }
            driver.Close();
        }

        [Test]
        public void ActiveLinkInNavBarIsMarked()
        {
            driver.Url = APP_URL;
            IReadOnlyCollection<IWebElement> navLinks = driver.FindElements(By.ClassName("nav-link"));
            int navLinksCount = navLinks.Count;
            Assert.AreEqual(4, navLinksCount);
            for (int currLinkIndex = 0; currLinkIndex < navLinksCount; currLinkIndex++)
            {
                IWebElement linkToClick = driver.FindElements(By.ClassName("nav-link"))[currLinkIndex];
                string[] hrefSplitted = linkToClick.GetAttribute("href").Split('/');
                string nextLinkUrl = hrefSplitted[hrefSplitted.GetUpperBound(0)];
                linkToClick.Click();
                IWebElement activeNavBarItem = driver.FindElement(By.CssSelector(string.Format("a[href = \"{0}\"]", nextLinkUrl)));
                Assert.AreEqual("underline", activeNavBarItem.GetCssValue("text-decoration-line"));
                Assert.AreEqual("true", activeNavBarItem.GetAttribute("aria-current"));
                Thread.Sleep(5000);
            }
            driver.Close();
        }

        [Test]
        public void LoginFormIsFunctional()
        {
            driver.Url = APP_URL;
            driver.FindElement(By.LinkText("Login/register")).Click();
            Assert.AreEqual("mathBoard - login to the site", driver.Title);
            IReadOnlyCollection<IWebElement> loginFields = driver.FindElements(By.Id("inputUserName"));
            Assert.AreEqual(1, loginFields.Count);
            IReadOnlyCollection<IWebElement> passwordFields = driver.FindElements(By.Id("password"));
            Assert.AreEqual(1, passwordFields.Count);
            IReadOnlyCollection<IWebElement> formSubmitButtons = driver.FindElements(By.CssSelector("button[type='submit']"));
            Assert.AreEqual(1, formSubmitButtons.Count);
            Assert.AreEqual("true", formSubmitButtons.ElementAt(0).GetAttribute("disabled"));
            loginFields.ElementAt(0).SendKeys("WebPageTester");
            Assert.AreEqual("true", formSubmitButtons.ElementAt(0).GetAttribute("disabled"));
            passwordFields.ElementAt(0).SendKeys("WebPageTester");
            Assert.IsNull(formSubmitButtons.ElementAt(0).GetAttribute("disabled"));
            Thread.Sleep(10000);
            driver.Close();
        }

        [Test]
        public void LoginWithCorrectCredentials()
        {
            driver.Url = APP_URL;
            Assert.Throws<NoSuchElementException>(
                () => { driver.FindElement(By.ClassName("fa-file"));
     });
            Assert.Throws<NoSuchElementException>(
    () => {
        driver.FindElement(By.ClassName("navbar-text"));
    });

            Assert.Throws<NoSuchElementException>(
() => {
driver.FindElement(By.ClassName("fa-sign-out-alt"));
});

            driver.FindElement(By.LinkText("Login/register")).Click();
            Assert.AreEqual("mathBoard - login to the site", driver.Title);
            IReadOnlyCollection<IWebElement> loginFields = driver.FindElements(By.Id("inputUserName"));
            IReadOnlyCollection<IWebElement> passwordFields = driver.FindElements(By.Id("password"));
            IReadOnlyCollection<IWebElement> formSubmitButtons = driver.FindElements(By.CssSelector("button[type='submit']"));
            loginFields.ElementAt(0).SendKeys("WebPageTester");
            passwordFields.ElementAt(0).SendKeys("Tester123!");
            formSubmitButtons.ElementAt(0).Click();
            Assert.AreEqual("Math board - welcome!", driver.Title);
            Assert.NotNull(driver.FindElement(By.ClassName("fa-file")));
            Assert.AreEqual("Logged in as WebPageTester", driver.FindElement(By.ClassName("navbar-text")).Text);
            driver.FindElement(By.ClassName("fa-sign-out-alt")).Click();
            Thread.Sleep(10000);
            driver.Close();
        }

        [Test]
        public void AttemptLoginWithIncorrectCredentials()
        {
            driver.Url = APP_URL;

            driver.FindElement(By.LinkText("Login/register")).Click();
            Assert.AreEqual("mathBoard - login to the site", driver.Title);
            IReadOnlyCollection<IWebElement> loginFields = driver.FindElements(By.Id("inputUserName"));
            IReadOnlyCollection<IWebElement> passwordFields = driver.FindElements(By.Id("password"));
            IReadOnlyCollection<IWebElement> formSubmitButtons = driver.FindElements(By.CssSelector("button[type='submit']"));
            loginFields.ElementAt(0).SendKeys("WebPageTestert");
            passwordFields.ElementAt(0).SendKeys("Tester123!");
            formSubmitButtons.ElementAt(0).Click();
            Assert.AreEqual("User name or password is incorrect.", driver.FindElement(By.ClassName("errorMessage_backend")).Text);
            loginFields = driver.FindElements(By.Id("inputUserName"));
            passwordFields = driver.FindElements(By.Id("password"));
            formSubmitButtons = driver.FindElements(By.CssSelector("button[type='submit']"));
            loginFields.ElementAt(0).Clear();
            loginFields.ElementAt(0).SendKeys("WebPageTester");
            passwordFields.ElementAt(0).SendKeys("Tester123!@");
            formSubmitButtons.ElementAt(0).Click();
            Assert.AreEqual("User name or password is incorrect.", driver.FindElement(By.ClassName("errorMessage_backend")).Text);
            Thread.Sleep(10000);
            driver.Close();
        }

        [Test]
        public void RegisterNewUser()
        {
            driver.Url = APP_URL;
            string randomLogin = GenerateRandomLogin();
            string password = "Testing123@";
            Login(randomLogin, password);
            Assert.AreEqual("User name or password is incorrect.", driver.FindElement(By.ClassName("errorMessage_backend")).Text);
            driver.FindElement(By.LinkText("create one!")).Click();
            Assert.AreEqual("mathBoard - create account", driver.Title);
            driver.FindElement(By.Id("registerUsername")).SendKeys(randomLogin);
            driver.FindElement(By.Id("typePassword")).SendKeys(password);
            driver.FindElement(By.Id("retypePassword")).SendKeys(password);
            driver.FindElement(By.Id("retypePassword")).Submit();
            WebDriverWait waitForTitle = new WebDriverWait(driver, TimeSpan.FromSeconds(10));
            waitForTitle.Until(SeleniumExtras.WaitHelpers.ExpectedConditions.TitleContains("mathBoard - login to the site"));

            Assert.AreEqual("mathBoard - login to the site", driver.Title);
            Login(randomLogin, password);
            Assert.AreEqual(string.Format("Logged in as {0}", randomLogin), driver.FindElement(By.ClassName("navbar-text")).Text);
            driver.FindElement(By.ClassName("fa-sign-out-alt")).Click();
            Thread.Sleep(10000);
            driver.Close();
        }


        [Test]
        public void RegisterFormClientSideValidation()
        {
            EventFiringWebDriver eventFiringDriver = new EventFiringWebDriver(driver)
            {
                Url = APP_URL
            };
            eventFiringDriver.FindElement(By.LinkText("Login/register")).Click();
            eventFiringDriver.FindElement(By.LinkText("create one!")).Click();
            IWebElement userNameField = eventFiringDriver.FindElement(By.Id("registerUsername"));
            IWebElement passwordField = eventFiringDriver.FindElement(By.Id("typePassword"));
            IWebElement confirmPassword = eventFiringDriver.FindElement(By.Id("retypePassword"));
            IWebElement registerBTN = eventFiringDriver.FindElement(By.CssSelector("button[type='submit']"));
            Assert.IsTrue(registerBTN.GetAttribute("class").Split(' ').Contains("btnDisabled"));
            Assert.AreEqual("true", registerBTN.GetAttribute("aria-disabled"));
            userNameField.SendKeys("asdfg");
            passwordField.SendKeys("");
            Assert.AreEqual("Username is to short. At least 6 characters.", eventFiringDriver.FindElement(By.CssSelector("#registerUsername + .errorMessage")).Text);
            Thread.Sleep(7000);
            Assert.IsTrue(registerBTN.GetAttribute("class").Split(' ').Contains("btnDisabled"));
            Assert.AreEqual("true", registerBTN.GetAttribute("aria-disabled"));
            userNameField.Clear();
            userNameField.SendKeys("asf!2asdf");
            passwordField.SendKeys("");
            Assert.AreEqual("Username can consist of latin letters and arabic digits.", eventFiringDriver.FindElement(By.CssSelector("#registerUsername + .errorMessage")).Text);
            Thread.Sleep(7000);
            Assert.IsTrue(registerBTN.GetAttribute("class").Split(' ').Contains("btnDisabled"));
            Assert.AreEqual("true", registerBTN.GetAttribute("aria-disabled"));
            userNameField.Clear();
            userNameField.Click();
            IJavaScriptExecutor jsExecutor = (IJavaScriptExecutor)eventFiringDriver;
            jsExecutor.ExecuteScript("arguments[0].value='WebPageTester';", userNameField);
            jsExecutor.ExecuteScript("arguments[0].dispatchEvent(new Event('input'));", userNameField);
            Thread.Sleep(10000);
            userNameField.SendKeys(Keys.Tab);
            //             jsExecutor.ExecuteScript("arguments[0].dispatchEvent(new Event('input'));", userNameField);
            passwordField.Click();
            Assert.AreEqual("This user name is currently used. Choose another.", eventFiringDriver.FindElement(By.CssSelector("#registerUsername + .errorMessage")).Text);
            Thread.Sleep(7000);
            Assert.IsTrue(registerBTN.GetAttribute("class").Split(' ').Contains("btnDisabled"));
            Assert.AreEqual("true", registerBTN.GetAttribute("aria-disabled"));
            userNameField.Clear();
            userNameField.SendKeys("sampleUserName");
            passwordField.SendKeys("asdfghj");
            confirmPassword.SendKeys("");
            Assert.AreEqual("Password must have atleast 8 characters.", eventFiringDriver.FindElement(By.XPath("/html/body/div[1]/div/div/div/div/form/div[2]/div/div[2]")).Text);
            Thread.Sleep(7000);
            Assert.IsTrue(registerBTN.GetAttribute("class").Split(' ').Contains("btnDisabled"));
            Assert.AreEqual("true", registerBTN.GetAttribute("aria-disabled"));
            passwordField.Clear();
            passwordField.SendKeys("asdfghjklm");
            confirmPassword.SendKeys("");
            Assert.AreEqual("Such password is insecure.", eventFiringDriver.FindElement(By.XPath("/html/body/div[1]/div/div/div/div/form/div[2]/div/div[2]")).Text);
            Thread.Sleep(7000);
            Assert.IsTrue(registerBTN.GetAttribute("class").Split(' ').Contains("btnDisabled"));
            Assert.AreEqual("true", registerBTN.GetAttribute("aria-disabled"));
            passwordField.Clear();
            passwordField.SendKeys("Testing123@");
            confirmPassword.SendKeys("Testing123");
            userNameField.SendKeys("");
            Assert.AreEqual("Passwords do not match.", eventFiringDriver.FindElement(By.CssSelector("#retypePassword + .errorMessage")).Text);
            Thread.Sleep(7000);
            confirmPassword.Clear();
            confirmPassword.SendKeys("Testing123@");
            userNameField.Click();
            Assert.IsFalse(registerBTN.GetAttribute("class").Split(' ').Contains("btnDisabled"));
            Assert.AreEqual("false", registerBTN.GetAttribute("aria-disabled"));
            Thread.Sleep(7000);
            driver.Quit();
        }

        [Test]
        public  void RegisterFormServerSideValidation()
        {
            FirefoxOptions opt = new FirefoxOptions();
            opt.SetPreference("javascript.enabled", false);
            IWebDriver d = new FirefoxDriver(opt)
            {
                Url = APP_URL
            };
            d.FindElement(By.LinkText("Login/register")).Click();
            d.FindElement(By.LinkText("create one!")).Click();
            IWebElement userNameField = d.FindElement(By.Id("registerUsername"));
            IWebElement passwordField = d.FindElement(By.Id("typePassword"));
            IWebElement confirmPassword = d.FindElement(By.Id("retypePassword"));
            IWebElement registerBTN = d.FindElement(By.CssSelector("button[type='submit']"));
            userNameField.SendKeys("asdfg");
            passwordField.SendKeys("Testing123!");
            confirmPassword.SendKeys("Testing123!");
            registerBTN.Click();
            Assert.AreEqual("Username is to short. At least 6 characters.", d.FindElement(By.CssSelector(".errorMessage_backend")).Text);
            Thread.Sleep(7000);
            userNameField = d.FindElement(By.Id("registerUsername"));
            passwordField = d.FindElement(By.Id("typePassword"));
            confirmPassword = d.FindElement(By.Id("retypePassword"));
            registerBTN = d.FindElement(By.CssSelector("button[type='submit']"));
            userNameField.SendKeys("WebPageTester");
            passwordField.SendKeys("Testing123!");
            confirmPassword.SendKeys("Testing123!");
            registerBTN.Click();
            Assert.AreEqual("This username is already taken.", d.FindElement(By.CssSelector(".errorMessage_backend")).Text);
            Thread.Sleep(7000);
            userNameField = d.FindElement(By.Id("registerUsername"));
            passwordField = d.FindElement(By.Id("typePassword"));
            confirmPassword = d.FindElement(By.Id("retypePassword"));
            registerBTN = d.FindElement(By.CssSelector("button[type='submit']"));
            userNameField.SendKeys("sampleUser");
            passwordField.SendKeys("Testing123@");
            confirmPassword.SendKeys("Testing123");
            registerBTN.Click();
            Assert.AreEqual("Password did not match.", d.FindElement(By.CssSelector("#retypePassword ~ .errorMessage_backend")).Text);
            Thread.Sleep(6000);
            driver.Close();
            d.Close();

        }

        [Test]
        public void EnsureMainPageIsResponsive()
        {
            FirefoxOptions opt = new FirefoxOptions();
            opt.AddArgument("--height=650");
            opt.AddArgument("--width==515");
            IWebDriver d = new FirefoxDriver(opt)
            {
                Url = APP_URL
            };
            Assert.IsTrue(d.FindElement(By.ClassName("navbar-toggler")).Displayed);
            Assert.AreEqual("515", d.FindElement(By.Id("canvas")).GetAttribute("width"));
            Thread.Sleep(5000);
            d.Close();
            driver.Url = APP_URL;
            Assert.IsFalse(driver.FindElement(By.ClassName("navbar-toggler")).Displayed);
            driver.Manage().Window.Maximize();
            var s = driver.Manage().Window.Size.Width;
            Assert.IsTrue(s >= Int16.Parse(driver.FindElement(By.Id("canvas")).GetAttribute("width")));
            Thread.Sleep(5000);
            driver.Close();
        }

        [Test]
        public void OpenNonExistentBoard()
        {
            driver.Url = APP_URL;
            driver.FindElement(By.LinkText("Open existing board")).Click();
            driver.FindElement(By.Id("boardName")).SendKeys(GenerateRandomLogin());
            driver.FindElement(By.Id("boardName")).Submit();
            WebDriverWait WaitForErrorMessage = new WebDriverWait(driver, TimeSpan.FromSeconds(15));
            WaitForErrorMessage.Until(SeleniumExtras.WaitHelpers.ExpectedConditions.TextToBePresentInElementLocated(By.ClassName("errorMessage_backend"), "Board with this name doesn't exist"));
            Assert.AreEqual("Board with this name doesn't exist", driver.FindElement(By.ClassName("errorMessage_backend")).Text);
            Thread.Sleep(7000);
            driver.Close();
        }


        [Test]
        public void BoardContentIsSaved()
        {
            driver.Url = APP_URL;
            Login("WebPageTester", "Tester123!");
            driver.FindElement(By.LinkText("Create new board")).Click();
            driver.FindElement(By.Id("newBoardName")).SendKeys("TestersBoard");
            driver.FindElement(By.Id("newBoardName")).Submit();
                WebDriverWait waitForEditor = new WebDriverWait(driver, TimeSpan.FromSeconds(15));
            waitForEditor.Until(SeleniumExtras.WaitHelpers.ExpectedConditions.ElementExists(By.TagName("textarea")));
            IWebElement editor = driver.FindElement(By.TagName("textarea"));
            editor.Clear();
            editor.SendKeys(@"$\frac{1}{2} + \frac{1}{4} = \frac{3}{4}$");
            Thread.Sleep(20000);
            driver.Close();
            driver = null;
            driver = new FirefoxDriver
            {
                Url = APP_URL
            };
            Login("WebPageTester", "Tester123!");
            driver.FindElement(By.LinkText("Create new board")).Click();
            driver.FindElement(By.Id("newBoardName")).SendKeys("TestersBoard");
            driver.FindElement(By.Id("newBoardName")).Submit();
            waitForEditor = new WebDriverWait(driver, TimeSpan.FromSeconds(15));
            waitForEditor.Until(SeleniumExtras.WaitHelpers.ExpectedConditions.ElementExists(By.TagName("textarea")));
            editor = driver.FindElement(By.TagName("textarea"));
            Assert.AreEqual(@"$\frac{1}{2} + \frac{1}{4} = \frac{3}{4}$", editor.Text);
            Thread.Sleep(5000);
            driver.Close();
        }


        [Test]
        public void BoardContentCanBeViewedWithoutLogin()
        {
            driver.Url = APP_URL;
            Login("WebPageTester", "Tester123!");
            driver.FindElement(By.LinkText("Create new board")).Click();
            driver.FindElement(By.Id("newBoardName")).SendKeys("TestersBoard");
            driver.FindElement(By.Id("newBoardName")).Submit();
            WebDriverWait waitForEditor = new WebDriverWait(driver, TimeSpan.FromSeconds(15));
            waitForEditor.Until(SeleniumExtras.WaitHelpers.ExpectedConditions.ElementExists(By.TagName("textarea")));
            IWebElement editor = driver.FindElement(By.TagName("textarea"));
            editor.Clear();
            editor.SendKeys(@"$\frac{1}{2} + \frac{1}{4} = \frac{3}{4}$");
            Thread.Sleep(20000);
            driver.Close();
            driver = null;
            driver = new FirefoxDriver
            {
                Url = APP_URL
            };
            driver.FindElement(By.LinkText("Open existing board")).Click();
            driver.FindElement(By.Id("boardName")).SendKeys("TestersBoard");
            driver.FindElement(By.Id("boardName")).Submit();
            WebDriverWait waitForContent = new WebDriverWait(driver, TimeSpan.FromSeconds(15));
            waitForContent.Until(SeleniumExtras.WaitHelpers.ExpectedConditions.ElementExists(By.TagName("pre")));
            Assert.AreEqual(@"$\frac{1}{2} + \frac{1}{4} = \frac{3}{4}$", driver.FindElement(By.TagName("pre")).Text);
            Thread.Sleep(5000);
            driver.Close();
        }

        private void Login(string userName, string password)
        {
            driver.FindElement(By.LinkText("Login/register")).Click();
            driver.FindElement(By.Id("inputUserName")).SendKeys(userName);
            driver.FindElement(By.Id("password")).SendKeys(password);
            driver.FindElement(By.CssSelector("button[type='submit']")).Click();
        }

        private string GenerateRandomLogin()
        {
            const string chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            return new string(Enumerable.Repeat(chars, 16)
              .Select(s => s[randomGenerator.Next(s.Length)]).ToArray());
        }
    }
    }
