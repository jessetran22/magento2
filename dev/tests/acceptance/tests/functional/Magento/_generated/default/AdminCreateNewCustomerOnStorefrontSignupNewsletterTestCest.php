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
 * @Title("MC-10914: Create New Customer on Storefront, Sign-up Newsletter")
 * @Description("Test log in to Create New Customer and Create New Customer on Storefront, Sign-up Newsletter<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCreateNewCustomerOnStorefrontSignupNewsletterTest.xml<br>")
 * @TestCaseId("MC-10914")
 * @group customer
 * @group mtf_migrated
 */
class AdminCreateNewCustomerOnStorefrontSignupNewsletterTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteNewUser] DeleteCustomerByEmailActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminCustomerPageLoadDeleteNewUser
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterButtonDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: clickFilterButtonDeleteNewUserWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteNewUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersDeleteNewUser
		$I->fillField("input[name=email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: filterEmailDeleteNewUser
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: applyFilterDeleteNewUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteNewUser
		$I->click("//td[@class='data-grid-checkbox-cell']"); // stepKey: clickOnEditButton1DeleteNewUser
		$I->click("//div[@class='col-xs-2']/div[@class='action-select-wrap']/button[@class='action-select']"); // stepKey: clickActionsDropdownDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: clickActionsDropdownDeleteNewUserWaitForPageLoad
		$I->click("//*[contains(@class,'admin__data-grid-header-row row row-gutter')]//*[text()='Delete']"); // stepKey: clickDeleteDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteNewUserWaitForPageLoad
		$I->waitForElementVisible("//button[@data-role='action']//span[text()='OK']", 30); // stepKey: waitForOkToVisibleDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: waitForOkToVisibleDeleteNewUserWaitForPageLoad
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOkConfirmationButtonDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: clickOkConfirmationButtonDeleteNewUserWaitForPageLoad
		$I->waitForElementVisible("//*[@class='message message-success success']", 30); // stepKey: waitForSuccessfullyDeletedMessageDeleteNewUser
		$I->comment("Exiting Action Group [deleteNewUser] DeleteCustomerByEmailActionGroup");
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
	 * @Stories({"Create New Customer"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateNewCustomerOnStorefrontSignupNewsletterTest(AcceptanceTester $I)
	{
		$I->comment("Create new customer on storefront and signup news letter");
		$I->comment("Entering Action Group [createCustomer] StorefrontCreateCustomerSignedUpNewsletterActionGroup");
		$I->amOnPage("/"); // stepKey: amOnStorefrontPageCreateCustomer
		$I->waitForPageLoad(30); // stepKey: waitForNavigateToCustomersPageLoadCreateCustomer
		$I->click("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]"); // stepKey: clickOnCreateAccountLinkCreateCustomer
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAccountLinkCreateCustomerWaitForPageLoad
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameCreateCustomer
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameCreateCustomer
		$I->checkOption("//span[contains(text(), 'Sign Up for Newsletter')]"); // stepKey: checkSignUpForNewsletterCreateCustomer
		$I->fillField("#email_address", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailCreateCustomer
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordCreateCustomer
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordCreateCustomer
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonCreateCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonCreateCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonToLoadCreateCustomer
		$I->comment("Exiting Action Group [createCustomer] StorefrontCreateCustomerSignedUpNewsletterActionGroup");
		$I->comment("Assert verify created new customer in grid");
		$I->comment("Entering Action Group [navigateToCustomers] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageNavigateToCustomers
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCustomers
		$I->comment("Exiting Action Group [navigateToCustomers] AdminOpenCustomersGridActionGroup");
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterButton
		$I->waitForPageLoad(30); // stepKey: clickFilterButtonWaitForPageLoad
		$I->fillField("input[name=email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: filterEmail
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFilter
		$I->waitForPageLoad(30); // stepKey: clickApplyFilterWaitForPageLoad
		$I->see("John", "table[data-role='grid']"); // stepKey: seeAssertCustomerFirstNameInGrid
		$I->see("Doe", "table[data-role='grid']"); // stepKey: seeAssertCustomerLastNameInGrid
		$I->see(msq("CustomerEntityOne") . "test@email.com", "table[data-role='grid']"); // stepKey: seeAssertCustomerEmailInGrid
		$I->comment("Assert verify created new customer is subscribed to newsletter");
		$I->comment("Entering Action Group [clickFirstRowEditLink] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickOnEditLinkClickFirstRowEditLink
		$I->waitForPageLoad(30); // stepKey: clickOnEditLinkClickFirstRowEditLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingClickFirstRowEditLink
		$I->comment("Exiting Action Group [clickFirstRowEditLink] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("//a[@class='admin__page-nav-link' and @id='tab_newsletter_content']"); // stepKey: clickNewsLetter
		$I->waitForPageLoad(30); // stepKey: clickNewsLetterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForNewsletterTabToOpen
		$I->seeCheckboxIsChecked("//div[@class='admin__field-control control']//input[@name='subscription_status[1]']"); // stepKey: seeAssertSubscribedToNewsletterCheckboxIsChecked
	}
}
