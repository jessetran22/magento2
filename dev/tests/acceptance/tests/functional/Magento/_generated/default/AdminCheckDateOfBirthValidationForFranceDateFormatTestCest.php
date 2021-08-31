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
 * @Title("[NO TESTCASEID]: Checks 'Date of Birth' field validation for the France date format value")
 * @Description("Checks 'Date of Birth' field validation for the France date format value<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCheckDateOfBirthValidationForFranceDateFormatTest.xml<br>")
 * @group customer
 * @group ui
 */
class AdminCheckDateOfBirthValidationForFranceDateFormatTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$deployStaticContentWithFrenchLocale = $I->magentoCLI("setup:static-content:deploy fr_FR", 60); // stepKey: deployStaticContentWithFrenchLocale
		$I->comment($deployStaticContentWithFrenchLocale);
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [setAdminInterfaceLocaleToFrance] SetAdminAccountActionGroup");
		$I->comment("Navigate to admin System Account Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_account/index/"); // stepKey: openAdminSystemAccountPageSetAdminInterfaceLocaleToFrance
		$I->waitForElementVisible("#interface_locale", 30); // stepKey: waitForInterfaceLocaleSetAdminInterfaceLocaleToFrance
		$I->comment("Change Admin locale to Français (France) / French (France)");
		$I->selectOption("#interface_locale", "fr_FR"); // stepKey: setInterfaceLocateSetAdminInterfaceLocaleToFrance
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordSetAdminInterfaceLocaleToFrance
		$I->click("#save"); // stepKey: clickSaveSetAdminInterfaceLocaleToFrance
		$I->waitForPageLoad(30); // stepKey: clickSaveSetAdminInterfaceLocaleToFranceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageSetAdminInterfaceLocaleToFrance
		$I->see("You saved the account.", "#messages div.message-success"); // stepKey: seeSuccessMessageSetAdminInterfaceLocaleToFrance
		$I->comment("Exiting Action Group [setAdminInterfaceLocaleToFrance] SetAdminAccountActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [setAdminInterfaceLocaleToDefaultValue] SetAdminAccountActionGroup");
		$I->comment("Navigate to admin System Account Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_account/index/"); // stepKey: openAdminSystemAccountPageSetAdminInterfaceLocaleToDefaultValue
		$I->waitForElementVisible("#interface_locale", 30); // stepKey: waitForInterfaceLocaleSetAdminInterfaceLocaleToDefaultValue
		$I->comment("Change Admin locale to Français (France) / French (France)");
		$I->selectOption("#interface_locale", "en_US"); // stepKey: setInterfaceLocateSetAdminInterfaceLocaleToDefaultValue
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordSetAdminInterfaceLocaleToDefaultValue
		$I->click("#save"); // stepKey: clickSaveSetAdminInterfaceLocaleToDefaultValue
		$I->waitForPageLoad(30); // stepKey: clickSaveSetAdminInterfaceLocaleToDefaultValueWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageSetAdminInterfaceLocaleToDefaultValue
		$I->see("You saved the account.", "#messages div.message-success"); // stepKey: seeSuccessMessageSetAdminInterfaceLocaleToDefaultValue
		$I->comment("Exiting Action Group [setAdminInterfaceLocaleToDefaultValue] SetAdminAccountActionGroup");
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
	 * @Stories({"Checks 'Date of Birth' field validation for the France date format value"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckDateOfBirthValidationForFranceDateFormatTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToNewCustomerPage] AdminNavigateNewCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/new"); // stepKey: navigateToCustomersNavigateToNewCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadNavigateToNewCustomerPage
		$I->comment("Exiting Action Group [navigateToNewCustomerPage] AdminNavigateNewCustomerActionGroup");
		$I->comment("Entering Action Group [assertDateOfBirthValidationMessage] AssertAdminCustomerDateOfBirthValidationMessageActionGroup");
		$I->fillField("//input[contains(@name, 'customer[dob]')]", "15/01/1970"); // stepKey: fillDateOfBirthAssertDateOfBirthValidationMessage
		$I->click("#save"); // stepKey: saveCustomerAssertDateOfBirthValidationMessage
		$I->waitForPageLoad(30); // stepKey: saveCustomerAssertDateOfBirthValidationMessageWaitForPageLoad
		$I->dontSee("The Date of Birth should not be greater than today.", "input[name='customer[dob]'] ~ label.admin__field-error"); // stepKey: seeTheErrorMessageIsDisplayedAssertDateOfBirthValidationMessage
		$I->comment("Exiting Action Group [assertDateOfBirthValidationMessage] AssertAdminCustomerDateOfBirthValidationMessageActionGroup");
	}
}
