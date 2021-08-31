<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-12666: Verify Shopping Cart Persistence under long-term cookie")
 * @Description("Verify Shopping Cart Persistence under long-term cookie<h3>Test files</h3>app/code/Magento/Persistent/Test/Mftf/Test/StorefrontVerifyShoppingCartPersistenceUnderLongTermCookieTest.xml<br>")
 * @TestCaseId("MC-12666")
 * @group persistent
 * @group customer
 */
class StorefrontVerifyShoppingCartPersistenceUnderLongTermCookieTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Enable Persistence");
		$I->createEntity("persistentConfigSetting", "hook", "PersistentConfigSettings", [], []); // stepKey: persistentConfigSetting
		$I->comment("Create Simple Product 1  and Product 2");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimple1", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimple1
		$I->createEntity("createSimple2", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimple2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Set Defaults Persistence configuration");
		$I->createEntity("persistentDefaultsConfiguration", "hook", "PersistentConfigUseSystemValue", [], []); // stepKey: persistentDefaultsConfiguration
		$I->comment("Delete Simple Product 1, Product 2 and Category");
		$I->deleteEntity("createSimple1", "hook"); // stepKey: deleteSimple1
		$I->deleteEntity("createSimple2", "hook"); // stepKey: deleteSimple2
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteJohnSmithCustomer] AdminDeleteCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersPageDeleteJohnSmithCustomer
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersDeleteJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteJohnSmithCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersClearDeleteJohnSmithCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersDeleteJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersDeleteJohnSmithCustomerWaitForPageLoad
		$I->fillField("input[name=email]", msq("John_Smith_Customer") . "john.smith@example.com"); // stepKey: fillEmailDeleteJohnSmithCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersDeleteJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteJohnSmithCustomerWaitForPageLoad
		$I->click("//*[contains(text(),'" . msq("John_Smith_Customer") . "john.smith@example.com')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: chooseCustomerDeleteJohnSmithCustomer
		$I->click(".admin__data-grid-header-row .action-select"); // stepKey: openActionsDeleteJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: waitActionsDeleteJohnSmithCustomer
		$I->click("//*[contains(@class, 'admin__data-grid-header')]//span[contains(@class,'action-menu-item') and text()='Delete']"); // stepKey: deleteDeleteJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationAlertDeleteJohnSmithCustomer
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: acceptDeleteJohnSmithCustomer
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteJohnSmithCustomer
		$I->see("A total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomersGridIsLoadedDeleteJohnSmithCustomer
		$I->comment("Exiting Action Group [deleteJohnSmithCustomer] AdminDeleteCustomerActionGroup");
		$I->comment("Entering Action Group [deleteJohnDoeCustomer] AdminDeleteCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersPageDeleteJohnDoeCustomer
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersDeleteJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteJohnDoeCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersClearDeleteJohnDoeCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersDeleteJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersDeleteJohnDoeCustomerWaitForPageLoad
		$I->fillField("input[name=email]", msq("Simple_Customer_Without_Address") . "John.Doe@example.com"); // stepKey: fillEmailDeleteJohnDoeCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersDeleteJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteJohnDoeCustomerWaitForPageLoad
		$I->click("//*[contains(text(),'" . msq("Simple_Customer_Without_Address") . "John.Doe@example.com')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: chooseCustomerDeleteJohnDoeCustomer
		$I->click(".admin__data-grid-header-row .action-select"); // stepKey: openActionsDeleteJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: waitActionsDeleteJohnDoeCustomer
		$I->click("//*[contains(@class, 'admin__data-grid-header')]//span[contains(@class,'action-menu-item') and text()='Delete']"); // stepKey: deleteDeleteJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationAlertDeleteJohnDoeCustomer
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: acceptDeleteJohnDoeCustomer
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteJohnDoeCustomer
		$I->see("A total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomersGridIsLoadedDeleteJohnDoeCustomer
		$I->comment("Exiting Action Group [deleteJohnDoeCustomer] AdminDeleteCustomerActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Persistent"})
	 * @Stories({"Shopping Cart Persistence"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyShoppingCartPersistenceUnderLongTermCookieTest(AcceptanceTester $I)
	{
		$I->comment("1. Go to storefront and click the Create an Account link");
		$I->comment("Entering Action Group [amOnHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnHomePage
		$I->comment("Exiting Action Group [amOnHomePage] StorefrontOpenHomePageActionGroup");
		$I->click("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]"); // stepKey: clickCreateAnAccountLink
		$I->waitForPageLoad(30); // stepKey: clickCreateAnAccountLinkWaitForPageLoad
		$I->comment("Entering Action Group [assertPersistentRegistrationPageFields] StorefrontAssertPersistentRegistrationPageFields");
		$I->seeInCurrentUrl("/customer/account/create/"); // stepKey: seeCreateNewCustomerAccountPageAssertPersistentRegistrationPageFields
		$I->seeElement("#firstname"); // stepKey: seeFirstNameFieldAssertPersistentRegistrationPageFields
		$I->seeElement("#lastname"); // stepKey: seeFLastNameFieldAssertPersistentRegistrationPageFields
		$I->seeElement("#email_address"); // stepKey: seeEmailFieldAssertPersistentRegistrationPageFields
		$I->seeElement("#password"); // stepKey: seePasswordFieldAssertPersistentRegistrationPageFields
		$I->seeElement("#password-confirmation"); // stepKey: seeConfirmPasswordFieldAssertPersistentRegistrationPageFields
		$I->seeCheckboxIsChecked("[name='persistent_remember_me']"); // stepKey: seeRememberMeCheckedAssertPersistentRegistrationPageFields
		$I->comment("Exiting Action Group [assertPersistentRegistrationPageFields] StorefrontAssertPersistentRegistrationPageFields");
		$I->comment("2. Fill fields for registration, set password and unselect the Remember Me checkbox");
		$I->comment("Entering Action Group [registrationJohnSmithCustomer] StorefrontCreateCustomerOnRegisterPageDoNotRememberMeActionGroup");
		$I->waitForElementVisible("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]", 30); // stepKey: waitForCreateAccountLinkRegistrationJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountLinkRegistrationJohnSmithCustomerWaitForPageLoad
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameRegistrationJohnSmithCustomer
		$I->fillField("#lastname", "Smith"); // stepKey: fillLastNameRegistrationJohnSmithCustomer
		$I->fillField("#email_address", msq("John_Smith_Customer") . "john.smith@example.com"); // stepKey: fillEmailRegistrationJohnSmithCustomer
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordRegistrationJohnSmithCustomer
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordRegistrationJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveRegistrationJohnSmithCustomer
		$I->uncheckOption("[name='persistent_remember_me']"); // stepKey: unCheckRememberMeRegistrationJohnSmithCustomer
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonRegistrationJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonRegistrationJohnSmithCustomerWaitForPageLoad
		$I->see("Thank you for registering with Main Website Store."); // stepKey: seeThankYouMessageRegistrationJohnSmithCustomer
		$I->see("John", ".box.box-information .box-content"); // stepKey: seeFirstNameRegistrationJohnSmithCustomer
		$I->see("Smith", ".box.box-information .box-content"); // stepKey: seeLastNameRegistrationJohnSmithCustomer
		$I->see(msq("John_Smith_Customer") . "john.smith@example.com", ".box.box-information .box-content"); // stepKey: seeEmailRegistrationJohnSmithCustomer
		$I->comment("- Assume we are on customer registration page.");
		$I->comment("Exiting Action Group [registrationJohnSmithCustomer] StorefrontCreateCustomerOnRegisterPageDoNotRememberMeActionGroup");
		$I->comment("Check customer name and last name in welcome message");
		$I->comment("Entering Action Group [customerCreatedSuccessMessageForJohnSmith] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with Main Website Store.", "#maincontent .message-success"); // stepKey: verifyMessageCustomerCreatedSuccessMessageForJohnSmith
		$I->comment("Exiting Action Group [customerCreatedSuccessMessageForJohnSmith] AssertMessageCustomerCreateAccountActionGroup");
		$I->comment("Entering Action Group [seeWelcomeMessageForJohnSmithCustomer] AssertCustomerWelcomeMessageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSeeWelcomeMessageForJohnSmithCustomer
		$I->see("Welcome, John Smith!", "header>.panel .greet.welcome"); // stepKey: verifyMessageSeeWelcomeMessageForJohnSmithCustomer
		$I->comment("Exiting Action Group [seeWelcomeMessageForJohnSmithCustomer] AssertCustomerWelcomeMessageActionGroup");
		$I->comment("3. Put Simple Product 1 into Shopping Cart");
		$I->comment("Entering Action Group [addSimple1ProductToCartForJohnSmithCustomer] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimple1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSimple1ProductToCartForJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSimple1ProductToCartForJohnSmithCustomer
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSimple1ProductToCartForJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: addToCartAddSimple1ProductToCartForJohnSmithCustomerWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSimple1ProductToCartForJohnSmithCustomer
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSimple1ProductToCartForJohnSmithCustomer
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSimple1ProductToCartForJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimple1ProductToCartForJohnSmithCustomer
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSimple1ProductToCartForJohnSmithCustomer
		$I->see("You added " . $I->retrieveEntityField('createSimple1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSimple1ProductToCartForJohnSmithCustomer
		$I->comment("Exiting Action Group [addSimple1ProductToCartForJohnSmithCustomer] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [checkSimple1InMiniCartForJohnSmithCustomer] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartCheckSimple1InMiniCartForJohnSmithCustomer
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleCheckSimple1InMiniCartForJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleCheckSimple1InMiniCartForJohnSmithCustomerWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimple1', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartCheckSimple1InMiniCartForJohnSmithCustomer
		$I->comment("Exiting Action Group [checkSimple1InMiniCartForJohnSmithCustomer] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("4. Click Sign Out");
		$I->comment("Entering Action Group [logoutJohnSmithCustomer] CustomerLogoutStorefrontByMenuItemsActionGroup");
		$I->conditionalClick(".panel.header .customer-welcome .customer-name", ".panel.header .customer-welcome .customer-menu .authorization-link a", false); // stepKey: clickHeaderCustomerMenuButtonLogoutJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: clickHeaderCustomerMenuButtonLogoutJohnSmithCustomerWaitForPageLoad
		$I->click(".panel.header .customer-welcome .customer-menu .authorization-link a"); // stepKey: clickSignOutButtonLogoutJohnSmithCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignOutButtonLogoutJohnSmithCustomerWaitForPageLoad
		$I->comment("Exiting Action Group [logoutJohnSmithCustomer] CustomerLogoutStorefrontByMenuItemsActionGroup");
		$I->comment("Entering Action Group [seeLogoutSuccessPageUrlAfterLogOutJohnSmithCustomer] AssertStorefrontCustomerLogoutSuccessPageActionGroup");
		$I->seeInCurrentUrl("customer/account/logoutSuccess/"); // stepKey: seeOnSignInPageSeeLogoutSuccessPageUrlAfterLogOutJohnSmithCustomer
		$I->comment("Exiting Action Group [seeLogoutSuccessPageUrlAfterLogOutJohnSmithCustomer] AssertStorefrontCustomerLogoutSuccessPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForRedirectToHomePage
		$I->waitForText("CMS homepage content goes here.", 30, "#maincontent"); // stepKey: waitForLoadContentMessage
		$I->comment("Entering Action Group [dontSeeWelcomeJohnSmithCustomerNotYouMessage] StorefrontAssertPersistentCustomerWelcomeMessageNotPresentActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDontSeeWelcomeJohnSmithCustomerNotYouMessage
		$I->dontSee("Welcome, John Smith! Not you?", "header>.panel .greet.welcome"); // stepKey: dontSeeWelcomeMessageNotYouDontSeeWelcomeJohnSmithCustomerNotYouMessage
		$I->comment("Exiting Action Group [dontSeeWelcomeJohnSmithCustomerNotYouMessage] StorefrontAssertPersistentCustomerWelcomeMessageNotPresentActionGroup");
		$I->comment("Entering Action Group [assertMiniCartEmptyAfterJohnSmithSignOut] AssertMiniCartEmptyActionGroup");
		$I->dontSeeElement("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: dontSeeMinicartProductCountAssertMiniCartEmptyAfterJohnSmithSignOut
		$I->click("a.showcart"); // stepKey: expandMinicartAssertMiniCartEmptyAfterJohnSmithSignOut
		$I->waitForPageLoad(60); // stepKey: expandMinicartAssertMiniCartEmptyAfterJohnSmithSignOutWaitForPageLoad
		$I->see("You have no items in your shopping cart.", "#minicart-content-wrapper"); // stepKey: seeEmptyCartMessageAssertMiniCartEmptyAfterJohnSmithSignOut
		$I->comment("Exiting Action Group [assertMiniCartEmptyAfterJohnSmithSignOut] AssertMiniCartEmptyActionGroup");
		$I->comment("5. Click the Create an Account link again and fill fields for registration of another customer, set password and check the Remember Me checkbox");
		$I->amOnPage("/customer/account/create/"); // stepKey: amOnCustomerAccountCreatePage
		$I->comment("Entering Action Group [registrationJohnDoeCustomer] StorefrontRegisterCustomerRememberMeActionGroup");
		$I->waitForElementVisible("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]", 30); // stepKey: waitForCreateAccountLinkRegistrationJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountLinkRegistrationJohnDoeCustomerWaitForPageLoad
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameRegistrationJohnDoeCustomer
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameRegistrationJohnDoeCustomer
		$I->fillField("#email_address", msq("Simple_Customer_Without_Address") . "John.Doe@example.com"); // stepKey: fillEmailRegistrationJohnDoeCustomer
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordRegistrationJohnDoeCustomer
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordRegistrationJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveRegistrationJohnDoeCustomer
		$I->checkOption("[name='persistent_remember_me']"); // stepKey: checkRememberMeRegistrationJohnDoeCustomer
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonRegistrationJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonRegistrationJohnDoeCustomerWaitForPageLoad
		$I->see("Thank you for registering with Main Website Store."); // stepKey: seeThankYouMessageRegistrationJohnDoeCustomer
		$I->see("John", ".box.box-information .box-content"); // stepKey: seeFirstNameRegistrationJohnDoeCustomer
		$I->see("Doe", ".box.box-information .box-content"); // stepKey: seeLastNameRegistrationJohnDoeCustomer
		$I->see(msq("Simple_Customer_Without_Address") . "John.Doe@example.com", ".box.box-information .box-content"); // stepKey: seeEmailRegistrationJohnDoeCustomer
		$I->comment("- Assume we are on customer registration page.");
		$I->comment("Exiting Action Group [registrationJohnDoeCustomer] StorefrontRegisterCustomerRememberMeActionGroup");
		$I->comment("Check customer name and last name in welcome message");
		$I->comment("Entering Action Group [customerCreatedSuccessMessageForJohnDoe] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with Main Website Store.", "#maincontent .message-success"); // stepKey: verifyMessageCustomerCreatedSuccessMessageForJohnDoe
		$I->comment("Exiting Action Group [customerCreatedSuccessMessageForJohnDoe] AssertMessageCustomerCreateAccountActionGroup");
		$I->comment("Entering Action Group [seeWelcomeMessageForJohnDoeCustomer] AssertCustomerWelcomeMessageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSeeWelcomeMessageForJohnDoeCustomer
		$I->see("Welcome, John Doe!", "header>.panel .greet.welcome"); // stepKey: verifyMessageSeeWelcomeMessageForJohnDoeCustomer
		$I->comment("Exiting Action Group [seeWelcomeMessageForJohnDoeCustomer] AssertCustomerWelcomeMessageActionGroup");
		$I->comment("6. Add Simple Product 1 to Shopping Cart");
		$I->comment("Entering Action Group [addSimple1ProductToCartForJohnDoeCustomer] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimple1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSimple1ProductToCartForJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSimple1ProductToCartForJohnDoeCustomer
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSimple1ProductToCartForJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: addToCartAddSimple1ProductToCartForJohnDoeCustomerWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSimple1ProductToCartForJohnDoeCustomer
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSimple1ProductToCartForJohnDoeCustomer
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSimple1ProductToCartForJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimple1ProductToCartForJohnDoeCustomer
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSimple1ProductToCartForJohnDoeCustomer
		$I->see("You added " . $I->retrieveEntityField('createSimple1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSimple1ProductToCartForJohnDoeCustomer
		$I->comment("Exiting Action Group [addSimple1ProductToCartForJohnDoeCustomer] AddSimpleProductToCartActionGroup");
		$I->see("1", "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: miniCartContainsOneProductForJohnDoeCustomer
		$I->comment("Entering Action Group [checkSimple1InMiniCartForJohnDoeCustomer] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartCheckSimple1InMiniCartForJohnDoeCustomer
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleCheckSimple1InMiniCartForJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleCheckSimple1InMiniCartForJohnDoeCustomerWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimple1', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartCheckSimple1InMiniCartForJohnDoeCustomer
		$I->comment("Exiting Action Group [checkSimple1InMiniCartForJohnDoeCustomer] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("7. Click Log Out");
		$I->comment("Entering Action Group [logoutJohnDoeCustomer] CustomerLogoutStorefrontByMenuItemsActionGroup");
		$I->conditionalClick(".panel.header .customer-welcome .customer-name", ".panel.header .customer-welcome .customer-menu .authorization-link a", false); // stepKey: clickHeaderCustomerMenuButtonLogoutJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: clickHeaderCustomerMenuButtonLogoutJohnDoeCustomerWaitForPageLoad
		$I->click(".panel.header .customer-welcome .customer-menu .authorization-link a"); // stepKey: clickSignOutButtonLogoutJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignOutButtonLogoutJohnDoeCustomerWaitForPageLoad
		$I->comment("Exiting Action Group [logoutJohnDoeCustomer] CustomerLogoutStorefrontByMenuItemsActionGroup");
		$I->comment("Entering Action Group [seeLogoutSuccessPageUrlAfterLogOutJohnDoeCustomer] AssertStorefrontCustomerLogoutSuccessPageActionGroup");
		$I->seeInCurrentUrl("customer/account/logoutSuccess/"); // stepKey: seeOnSignInPageSeeLogoutSuccessPageUrlAfterLogOutJohnDoeCustomer
		$I->comment("Exiting Action Group [seeLogoutSuccessPageUrlAfterLogOutJohnDoeCustomer] AssertStorefrontCustomerLogoutSuccessPageActionGroup");
		$I->comment("Entering Action Group [seeWelcomeForJohnDoeCustomer] StorefrontAssertPersistentCustomerWelcomeMessageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSeeWelcomeForJohnDoeCustomer
		$I->see("Welcome, John Doe! Not you?", "header>.panel .greet.welcome"); // stepKey: verifyMessageSeeWelcomeForJohnDoeCustomer
		$I->comment("Exiting Action Group [seeWelcomeForJohnDoeCustomer] StorefrontAssertPersistentCustomerWelcomeMessageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad
		$I->waitForText("CMS homepage content goes here.", 30, "#maincontent"); // stepKey: waitForLoadContentMessageOnHomePage
		$I->waitForElementVisible("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']", 30); // stepKey: waitForCartCounterVisible
		$I->see("1", "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: miniCartContainsOneProductForGuest
		$I->comment("Entering Action Group [checkSimple1InMiniCartForGuestCustomer] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartCheckSimple1InMiniCartForGuestCustomer
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleCheckSimple1InMiniCartForGuestCustomer
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleCheckSimple1InMiniCartForGuestCustomerWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimple1', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartCheckSimple1InMiniCartForGuestCustomer
		$I->comment("Exiting Action Group [checkSimple1InMiniCartForGuestCustomer] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("8. Go to Shopping Cart and verify Simple Product 1 is present there");
		$I->comment("Entering Action Group [goToShoppingCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingCart
		$I->comment("Exiting Action Group [goToShoppingCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->see($I->retrieveEntityField('createSimple1', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: checkSimple1InShoppingCart
		$I->comment("9. Add Simple Product 2 to Shopping Cart");
		$I->comment("Entering Action Group [addSimple2ProductToCartForGuest] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimple2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSimple2ProductToCartForGuest
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSimple2ProductToCartForGuest
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSimple2ProductToCartForGuest
		$I->waitForPageLoad(30); // stepKey: addToCartAddSimple2ProductToCartForGuestWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSimple2ProductToCartForGuest
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSimple2ProductToCartForGuest
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSimple2ProductToCartForGuest
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimple2ProductToCartForGuest
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSimple2ProductToCartForGuest
		$I->see("You added " . $I->retrieveEntityField('createSimple2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSimple2ProductToCartForGuest
		$I->comment("Exiting Action Group [addSimple2ProductToCartForGuest] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [checkSimple1InMiniCartForGuestCustomerSecondTime] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartCheckSimple1InMiniCartForGuestCustomerSecondTime
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleCheckSimple1InMiniCartForGuestCustomerSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleCheckSimple1InMiniCartForGuestCustomerSecondTimeWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimple1', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartCheckSimple1InMiniCartForGuestCustomerSecondTime
		$I->comment("Exiting Action Group [checkSimple1InMiniCartForGuestCustomerSecondTime] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Entering Action Group [checkSimple2InMiniCartForGuestCustomer] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartCheckSimple2InMiniCartForGuestCustomer
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleCheckSimple2InMiniCartForGuestCustomer
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleCheckSimple2InMiniCartForGuestCustomerWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimple2', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartCheckSimple2InMiniCartForGuestCustomer
		$I->comment("Exiting Action Group [checkSimple2InMiniCartForGuestCustomer] AssertOneProductNameInMiniCartActionGroup");
		$I->see("2", "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: miniCartContainsTwoProductForGuest
		$I->comment("10. Go to My Account section");
		$I->comment("Entering Action Group [amOnCustomerAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageAmOnCustomerAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCustomerAccountPage
		$I->comment("Exiting Action Group [amOnCustomerAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->seeInCurrentUrl("/customer/account/login/"); // stepKey: redirectToCustomerAccountLoginPage
		$I->seeElement(".login-container .block.block-customer-login"); // stepKey: checkSystemRequiresToLogIn
		$I->comment("11. Log in as John Doe");
		$I->comment("Entering Action Group [logInAsJohnDoeCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLogInAsJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLogInAsJohnDoeCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLogInAsJohnDoeCustomer
		$I->fillField("#email", msq("Simple_Customer_Without_Address") . "John.Doe@example.com"); // stepKey: fillEmailLogInAsJohnDoeCustomer
		$I->fillField("#pass", "pwdTest123!"); // stepKey: fillPasswordLogInAsJohnDoeCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLogInAsJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLogInAsJohnDoeCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLogInAsJohnDoeCustomer
		$I->comment("Exiting Action Group [logInAsJohnDoeCustomer] LoginToStorefrontActionGroup");
		$I->see("2", "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: miniCartContainsTwoProductForJohnDoeCustomer
		$I->comment("Entering Action Group [checkSimple1InMiniCartForJohnDoeCustomerSecondTime] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartCheckSimple1InMiniCartForJohnDoeCustomerSecondTime
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleCheckSimple1InMiniCartForJohnDoeCustomerSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleCheckSimple1InMiniCartForJohnDoeCustomerSecondTimeWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimple1', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartCheckSimple1InMiniCartForJohnDoeCustomerSecondTime
		$I->comment("Exiting Action Group [checkSimple1InMiniCartForJohnDoeCustomerSecondTime] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Entering Action Group [checkSimple2InMiniCartForJohnDoeCustomer] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartCheckSimple2InMiniCartForJohnDoeCustomer
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleCheckSimple2InMiniCartForJohnDoeCustomer
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleCheckSimple2InMiniCartForJohnDoeCustomerWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimple2', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartCheckSimple2InMiniCartForJohnDoeCustomer
		$I->comment("Exiting Action Group [checkSimple2InMiniCartForJohnDoeCustomer] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("12. Sign out and click the Not you? link");
		$I->comment("Entering Action Group [logoutJohnDoeCustomerSecondTime] CustomerLogoutStorefrontByMenuItemsActionGroup");
		$I->conditionalClick(".panel.header .customer-welcome .customer-name", ".panel.header .customer-welcome .customer-menu .authorization-link a", false); // stepKey: clickHeaderCustomerMenuButtonLogoutJohnDoeCustomerSecondTime
		$I->waitForPageLoad(30); // stepKey: clickHeaderCustomerMenuButtonLogoutJohnDoeCustomerSecondTimeWaitForPageLoad
		$I->click(".panel.header .customer-welcome .customer-menu .authorization-link a"); // stepKey: clickSignOutButtonLogoutJohnDoeCustomerSecondTime
		$I->waitForPageLoad(30); // stepKey: clickSignOutButtonLogoutJohnDoeCustomerSecondTimeWaitForPageLoad
		$I->comment("Exiting Action Group [logoutJohnDoeCustomerSecondTime] CustomerLogoutStorefrontByMenuItemsActionGroup");
		$I->comment("Entering Action Group [seeLogoutSuccessPageUrlAfterLogOutJohnSmithCustomerSecondTime] AssertStorefrontCustomerLogoutSuccessPageActionGroup");
		$I->seeInCurrentUrl("customer/account/logoutSuccess/"); // stepKey: seeOnSignInPageSeeLogoutSuccessPageUrlAfterLogOutJohnSmithCustomerSecondTime
		$I->comment("Exiting Action Group [seeLogoutSuccessPageUrlAfterLogOutJohnSmithCustomerSecondTime] AssertStorefrontCustomerLogoutSuccessPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoadAfter5Seconds
		$I->waitForText("CMS homepage content goes here.", 30, "#maincontent"); // stepKey: waitForLoadMainContentMessageOnHomePage
		$I->click(".greet.welcome span a"); // stepKey: clickOnNotYouLink
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoginPageLoad
		$I->comment("Entering Action Group [assertMiniCartEmptyAfterJohnDoeSignOut] AssertMiniCartEmptyActionGroup");
		$I->dontSeeElement("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: dontSeeMinicartProductCountAssertMiniCartEmptyAfterJohnDoeSignOut
		$I->click("a.showcart"); // stepKey: expandMinicartAssertMiniCartEmptyAfterJohnDoeSignOut
		$I->waitForPageLoad(60); // stepKey: expandMinicartAssertMiniCartEmptyAfterJohnDoeSignOutWaitForPageLoad
		$I->see("You have no items in your shopping cart.", "#minicart-content-wrapper"); // stepKey: seeEmptyCartMessageAssertMiniCartEmptyAfterJohnDoeSignOut
		$I->comment("Exiting Action Group [assertMiniCartEmptyAfterJohnDoeSignOut] AssertMiniCartEmptyActionGroup");
	}
}
