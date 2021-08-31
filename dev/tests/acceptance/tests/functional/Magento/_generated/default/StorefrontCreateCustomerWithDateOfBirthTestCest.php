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
 * @Title("MC-32413: Customer should be able to create an account with date of birth via the storefront")
 * @Description("Customer should be able to create an account with date of birth via the storefront<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontCreateCustomerWithDateOfBirthTest.xml<br>")
 * @TestCaseId("MC-32413")
 * @group customer
 * @group create
 */
class StorefrontCreateCustomerWithDateOfBirthTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Entering Action Group [showDateOfBirth] AdminCustomerShowDateOfBirthActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/customer/#customer_address-link"); // stepKey: openCustomerConfigPageShowDateOfBirth
		$I->waitForPageLoad(30); // stepKey: waitCustomerConfigPageShowDateOfBirth
		$I->scrollTo("#customer_address_dob_show", 0, -100); // stepKey: scrollToShowDateOfBirthShowDateOfBirth
		$I->uncheckOption("#customer_address_dob_show_inherit"); // stepKey: uncheckUseSystemShowDateOfBirth
		$I->selectOption("#customer_address_dob_show", "Required"); // stepKey: fillShowDateOfBirthShowDateOfBirth
		$I->click("#save"); // stepKey: clickSaveShowDateOfBirth
		$I->waitForPageLoad(30); // stepKey: clickSaveShowDateOfBirthWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessMessageShowDateOfBirth
		$I->comment("Exiting Action Group [showDateOfBirth] AdminCustomerShowDateOfBirthActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [hideDateOfBirth] AdminCustomerShowDateOfBirthActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/customer/#customer_address-link"); // stepKey: openCustomerConfigPageHideDateOfBirth
		$I->waitForPageLoad(30); // stepKey: waitCustomerConfigPageHideDateOfBirth
		$I->scrollTo("#customer_address_dob_show", 0, -100); // stepKey: scrollToShowDateOfBirthHideDateOfBirth
		$I->uncheckOption("#customer_address_dob_show_inherit"); // stepKey: uncheckUseSystemHideDateOfBirth
		$I->selectOption("#customer_address_dob_show", "No"); // stepKey: fillShowDateOfBirthHideDateOfBirth
		$I->click("#save"); // stepKey: clickSaveHideDateOfBirth
		$I->waitForPageLoad(30); // stepKey: clickSaveHideDateOfBirthWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessMessageHideDateOfBirth
		$I->comment("Exiting Action Group [hideDateOfBirth] AdminCustomerShowDateOfBirthActionGroup");
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
	 * @Features({"Customer"})
	 * @Stories({"Create a Customer via the Storefront"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCreateCustomerWithDateOfBirthTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [SignUpNewUser] StorefrontCustomerCreateAccountWithDateOfBirthActionGroup");
		$I->amOnPage("/"); // stepKey: amOnStorefrontPageSignUpNewUser
		$I->waitForElementVisible("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]", 30); // stepKey: waitForCreateAccountLinkSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountLinkSignUpNewUserWaitForPageLoad
		$I->click("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]"); // stepKey: clickOnCreateAccountLinkSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAccountLinkSignUpNewUserWaitForPageLoad
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameSignUpNewUser
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameSignUpNewUser
		$I->fillField("#dob", "9/21/1993"); // stepKey: fillDobSignUpNewUser
		$I->fillField("#email_address", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailSignUpNewUser
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordSignUpNewUser
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSignUpNewUser
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSignUpNewUserWaitForPageLoad
		$I->see("Thank you for registering with Main Website Store."); // stepKey: seeThankYouMessageSignUpNewUser
		$I->see("John", ".box.box-information .box-content"); // stepKey: seeFirstNameSignUpNewUser
		$I->see("Doe", ".box.box-information .box-content"); // stepKey: seeLastNameSignUpNewUser
		$I->see(msq("CustomerEntityOne") . "test@email.com", ".box.box-information .box-content"); // stepKey: seeEmailSignUpNewUser
		$I->comment("Exiting Action Group [SignUpNewUser] StorefrontCustomerCreateAccountWithDateOfBirthActionGroup");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "customer_grid"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
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
	}
}
