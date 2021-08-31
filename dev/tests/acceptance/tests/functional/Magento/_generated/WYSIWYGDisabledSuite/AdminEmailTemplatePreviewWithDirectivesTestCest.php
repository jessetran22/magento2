<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("[NO TESTCASEID]: Check email template preview with directives")
 * @Description("Check if email template preview works correctly with directives<h3>Test files</h3>app/code/Magento/Email/Test/Mftf/Test/AdminEmailTemplatePreviewWithDirectivesTest.xml<br>")
 * @group email
 * @group WYSIWYGDisabled
 */
class AdminEmailTemplatePreviewWithDirectivesTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login to Admin Area");
		$I->comment("Entering Action Group [loginToAdminArea] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminArea
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminArea
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminArea
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminArea
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminAreaWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminArea
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminArea
		$I->comment("Exiting Action Group [loginToAdminArea] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created Template");
		$I->comment("Entering Action Group [deleteTemplate] DeleteEmailTemplateActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/email_template/"); // stepKey: navigateEmailTemplatePageDeleteTemplate
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clearFiltersDeleteTemplate
		$I->waitForPageLoad(30); // stepKey: clearFiltersDeleteTemplateWaitForPageLoad
		$I->fillField("#systemEmailTemplateGrid_filter_code", "Template" . msq("EmailTemplate")); // stepKey: findCreatedTemplateDeleteTemplate
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteTemplate
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteTemplateWaitForPageLoad
		$I->waitForElementVisible("//*[@id='systemEmailTemplateGrid_table']//td[contains(@class, 'col-code') and normalize-space(.)='Template" . msq("EmailTemplate") . "']/ancestor::tr", 30); // stepKey: waitForTemplatesAppearedDeleteTemplate
		$I->click("//*[@id='systemEmailTemplateGrid_table']//td[contains(@class, 'col-code') and normalize-space(.)='Template" . msq("EmailTemplate") . "']/ancestor::tr"); // stepKey: clickToOpenTemplateDeleteTemplate
		$I->waitForElementVisible("#template_code", 30); // stepKey: waitForTemplateNameisibleDeleteTemplate
		$I->seeInField("#template_code", "Template" . msq("EmailTemplate")); // stepKey: checkTemplateNameDeleteTemplate
		$I->click("#delete"); // stepKey: deleteTemplateDeleteTemplate
		$I->waitForElementVisible(".action-accept", 30); // stepKey: waitForConfirmButtonDeleteTemplate
		$I->click(".action-accept"); // stepKey: acceptPopupDeleteTemplate
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteTemplate
		$I->see("You deleted the email template.", "#messages div.message-success"); // stepKey: seeSuccessfulMessageDeleteTemplate
		$I->comment("Exiting Action Group [deleteTemplate] DeleteEmailTemplateActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClearFilters
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClearFiltersWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClearFilters
		$I->comment("Exiting Action Group [clearFilters] AdminClearGridFiltersActionGroup");
		$I->comment("Logout from Admin Area");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Email"})
	 * @Stories({"Create email template with directives", "Email Template Preview"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEmailTemplatePreviewWithDirectivesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [createTemplate] CreateCustomTemplateActionGroup");
		$I->comment("Go to Marketing> Email Templates");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/email_template/"); // stepKey: navigateToEmailTemplatePageCreateTemplate
		$I->comment("Click \"Add New Template\" button");
		$I->click("#add"); // stepKey: clickAddNewTemplateButtonCreateTemplate
		$I->waitForPageLoad(30); // stepKey: clickAddNewTemplateButtonCreateTemplateWaitForPageLoad
		$I->comment("Select value for \"Template\" drop-down menu in \"Load Default Template\" tab");
		$I->comment("Fill in required fields in \"Template Information\" tab and click \"Save Template\" button");
		$I->fillField("#template_code", "Template" . msq("EmailTemplate")); // stepKey: fillTemplateNameFieldCreateTemplate
		$I->fillField("#template_subject", "Template Subject_" . msq("EmailTemplateWithDirectives")); // stepKey: fillTemplateSubjectCreateTemplate
		$I->fillField("#template_text", "Template {{var this.template_id}}:{{var this.getData(template_id)}} Text"); // stepKey: fillTemplateTextCreateTemplate
		$I->click("#save"); // stepKey: clickSaveTemplateButtonCreateTemplate
		$I->waitForPageLoad(30); // stepKey: clickSaveTemplateButtonCreateTemplateWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageCreateTemplate
		$I->see("You saved the email template.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateTemplate
		$I->comment("Exiting Action Group [createTemplate] CreateCustomTemplateActionGroup");
		$I->comment("Entering Action Group [previewTemplate] PreviewEmailTemplateActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/email_template/"); // stepKey: navigateEmailTemplatePagePreviewTemplate
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clearFiltersPreviewTemplate
		$I->waitForPageLoad(30); // stepKey: clearFiltersPreviewTemplateWaitForPageLoad
		$I->fillField("#systemEmailTemplateGrid_filter_code", "Template" . msq("EmailTemplate")); // stepKey: findCreatedTemplatePreviewTemplate
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchPreviewTemplate
		$I->waitForPageLoad(30); // stepKey: clickSearchPreviewTemplateWaitForPageLoad
		$I->waitForElementVisible("//*[@id='systemEmailTemplateGrid_table']//td[contains(@class, 'col-code') and normalize-space(.)='Template" . msq("EmailTemplate") . "']/ancestor::tr", 30); // stepKey: waitForTemplatesAppearedPreviewTemplate
		$I->click("//*[@id='systemEmailTemplateGrid_table']//td[contains(@class, 'col-code') and normalize-space(.)='Template" . msq("EmailTemplate") . "']/ancestor::tr"); // stepKey: clickToOpenTemplatePreviewTemplate
		$I->waitForElementVisible("#template_code", 30); // stepKey: waitForTemplateNameisiblePreviewTemplate
		$I->seeInField("#template_code", "Template" . msq("EmailTemplate")); // stepKey: checkTemplateNamePreviewTemplate
		$I->click("#preview"); // stepKey: clickPreviewTemplatePreviewTemplate
		$I->waitForPageLoad(30); // stepKey: clickPreviewTemplatePreviewTemplateWaitForPageLoad
		$I->switchToNextTab(); // stepKey: switchToNewOpenedTabPreviewTemplate
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/email_template/preview/"); // stepKey: seeCurrentUrlPreviewTemplate
		$I->seeElement("#preview_iframe"); // stepKey: seeIframeOnPagePreviewTemplate
		$I->switchToIFrame("preview_iframe"); // stepKey: switchToIframePreviewTemplate
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedPreviewTemplate
		$I->comment("Exiting Action Group [previewTemplate] PreviewEmailTemplateActionGroup");
		$I->comment("Entering Action Group [assertContent] AssertEmailTemplateContentActionGroup");
		$I->see("Template : Text"); // stepKey: checkTemplateContainTextAssertContent
		$I->comment("Exiting Action Group [assertContent] AssertEmailTemplateContentActionGroup");
	}
}
