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
 * @Title("MC-10915: Create New Customer on Storefront")
 * @Description("Test log in to Create New Customer and Create New Customer on Storefront<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCreateNewCustomerOnStorefrontTest.xml<br>")
 * @TestCaseId("MC-10915")
 * @group customer
 * @group mtf_migrated
 */
class AdminCreateNewCustomerOnStorefrontTestCest
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
	public function AdminCreateNewCustomerOnStorefrontTest(AcceptanceTester $I)
	{
		$I->comment("Create new customer on storefront and perform the asserts");
		$I->comment("Entering Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->amOnPage("/customer/account/create/"); // stepKey: goToCustomerAccountCreatePageOpenCreateAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCreateAccountPage
		$I->comment("Exiting Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->comment("Entering Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillCreateAccountForm
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillCreateAccountForm
		$I->fillField("#email_address", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailFillCreateAccountForm
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordFillCreateAccountForm
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordFillCreateAccountForm
		$I->comment("Exiting Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSubmitCreateAccountForm
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSubmitCreateAccountForm
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSubmitCreateAccountFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedSubmitCreateAccountForm
		$I->comment("Exiting Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with Main Website Store.", "#maincontent .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->comment("Entering Action Group [assertSignedUpNewsLetter] AssertSignedUpNewsletterActionGroup");
		$I->see("Thank you for registering with Main Website Store.", ".message-success"); // stepKey: successMessageAssertSignedUpNewsLetter
		$I->see("John", ".box.box-information .box-content"); // stepKey: seeFirstNameAssertSignedUpNewsLetter
		$I->see("Doe", ".box.box-information .box-content"); // stepKey: seeLastNameAssertSignedUpNewsLetter
		$I->see(msq("CustomerEntityOne") . "test@email.com", ".box.box-information .box-content"); // stepKey: seeEmailAssertSignedUpNewsLetter
		$I->seeInCurrentUrl("/customer/account/"); // stepKey: seeAssertInCurrentUrlAssertSignedUpNewsLetter
		$I->comment("Exiting Action Group [assertSignedUpNewsLetter] AssertSignedUpNewsletterActionGroup");
	}
}
