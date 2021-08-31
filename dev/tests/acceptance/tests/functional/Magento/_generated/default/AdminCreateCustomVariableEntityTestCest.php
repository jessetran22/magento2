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
 * @Title("MC-14253: Admin Create Custom Variable")
 * @Description("Test for creating a custom variable.<h3>Test files</h3>app/code/Magento/Variable/Test/Mftf/Test/AdminCreateCustomVariableEntityTest.xml<br>")
 * @TestCaseId("MC-14253")
 * @group variable
 * @group mtf_migrated
 */
class AdminCreateCustomVariableEntityTestCest
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
	 * @Features({"Variable"})
	 * @Stories({"Create Custom Variable."})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCustomVariableEntityTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToNewVariableAdminPage] AdminOpenNewVariablePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_variable/new/"); // stepKey: openNewVariablePageGoToNewVariableAdminPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToNewVariableAdminPage
		$I->comment("Exiting Action Group [goToNewVariableAdminPage] AdminOpenNewVariablePageActionGroup");
		$I->comment("Entering Action Group [fillInCustomVariableData] AdminFillVariableFormActionGroup");
		$I->fillField("#edit_form input[name='variable[code]']", "variable-code-" . msq("SampleVariable")); // stepKey: fillVariableCodeFillInCustomVariableData
		$I->fillField("#edit_form input[name='variable[name]']", "Test Sample Variable"); // stepKey: fillVariableNameFillInCustomVariableData
		$I->fillField("#edit_form textarea[name='variable[html_value]']", "Test Sample Variable HTML value"); // stepKey: fillVariableHtmlFillInCustomVariableData
		$I->fillField("#edit_form textarea[name='variable[plain_value]']", "Test Sample Variable PLAIN value"); // stepKey: fillVariablePlainFillInCustomVariableData
		$I->comment("Exiting Action Group [fillInCustomVariableData] AdminFillVariableFormActionGroup");
		$I->comment("Entering Action Group [clickSaveCustomVariable] AdminClickFormActionButtonActionGroup");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForButtonClickSaveCustomVariable
		$I->waitForPageLoad(30); // stepKey: waitForButtonClickSaveCustomVariableWaitForPageLoad
		$I->click("#save"); // stepKey: clickButtonClickSaveCustomVariable
		$I->waitForPageLoad(30); // stepKey: clickButtonClickSaveCustomVariableWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickSaveCustomVariable
		$I->comment("Exiting Action Group [clickSaveCustomVariable] AdminClickFormActionButtonActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeSuccessMessage
		$I->see("You saved the custom variable.", "#messages div.message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [filterVariablesGrid] AdminFilterVariableGridActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersFilterVariablesGrid
		$I->waitForPageLoad(30); // stepKey: waitForFilterResetFilterVariablesGrid
		$I->fillField("[data-role='filter-form'] input.admin__control-text[name='code']", "variable-code-" . msq("SampleVariable")); // stepKey: fillCodeFieldInFilterFilterVariablesGrid
		$I->fillField("[data-role='filter-form'] input.admin__control-text[name='name']", "Test Sample Variable"); // stepKey: fillNameFieldInFilterFilterVariablesGrid
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFilterVariablesGrid
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterVariablesGrid
		$I->comment("Exiting Action Group [filterVariablesGrid] AdminFilterVariableGridActionGroup");
		$I->comment("Entering Action Group [seeNewVariableInGrid] AssertAdminCustomVariableInGridActionGroup");
		$I->see("variable-code-" . msq("SampleVariable"), "//tbody/tr[td[text()[normalize-space()='variable-code-" . msq("SampleVariable") . "']]]"); // stepKey: seeVariableCodeSeeNewVariableInGrid
		$I->see("Test Sample Variable", "//tbody/tr[td[text()[normalize-space()='variable-code-" . msq("SampleVariable") . "']]]"); // stepKey: seeVariableNameSeeNewVariableInGrid
		$I->comment("Exiting Action Group [seeNewVariableInGrid] AssertAdminCustomVariableInGridActionGroup");
		$I->comment("Entering Action Group [openVariableEditPage] AdminNavigateToVariablePageByCodeActionGroup");
		$I->click("//tbody/tr[td[text()[normalize-space()='variable-code-" . msq("SampleVariable") . "']]]"); // stepKey: goToCustomVariableEditPageOpenVariableEditPage
		$I->waitForPageLoad(30); // stepKey: waitForVariableEditPageOpenOpenVariableEditPage
		$I->comment("Exiting Action Group [openVariableEditPage] AdminNavigateToVariablePageByCodeActionGroup");
		$I->comment("Entering Action Group [assertCustomVariableForm] AssertAdminCustomVariableFormActionGroup");
		$I->seeInField("#edit_form input[name='variable[code]']", "variable-code-" . msq("SampleVariable")); // stepKey: seeVariableCodeAssertCustomVariableForm
		$I->seeInField("#edit_form input[name='variable[name]']", "Test Sample Variable"); // stepKey: seeVariableNameAssertCustomVariableForm
		$I->seeInField("#edit_form textarea[name='variable[html_value]']", "Test Sample Variable HTML value"); // stepKey: seeVariableHtmlAssertCustomVariableForm
		$I->seeInField("#edit_form textarea[name='variable[plain_value]']", "Test Sample Variable PLAIN value"); // stepKey: seeVariablePlainAssertCustomVariableForm
		$I->comment("Exiting Action Group [assertCustomVariableForm] AssertAdminCustomVariableFormActionGroup");
	}
}
