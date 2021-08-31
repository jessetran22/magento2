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
 * @Title("[NO TESTCASEID]: Check email template preview with directives and preview as draft")
 * @Description("Check if email template preview works correctly with directives in draft mode<h3>Test files</h3>app/code/Magento/Email/Test/Mftf/Test/AdminEmailTemplatePreviewAsDraftWithDirectivesTest.xml<br>")
 * @group email
 * @group WYSIWYGDisabled
 */
class AdminEmailTemplatePreviewAsDraftWithDirectivesTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
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
	 * @Stories({"Create email template with directives and preview as draft", "Email Template Preview"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEmailTemplatePreviewAsDraftWithDirectivesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [createDraftTemplate] PrepareDraftCustomTemplateActionGroup");
		$I->comment("Go to Marketing> Email Templates");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/email_template/"); // stepKey: navigateToEmailTemplatePageCreateDraftTemplate
		$I->comment("Click \"Add New Template\" button");
		$I->click("#add"); // stepKey: clickAddNewTemplateButtonCreateDraftTemplate
		$I->waitForPageLoad(30); // stepKey: clickAddNewTemplateButtonCreateDraftTemplateWaitForPageLoad
		$I->comment("Select value for \"Template\" drop-down menu in \"Load Default Template\" tab");
		$I->comment("Fill in required fields in \"Template Information\" tab and click \"Save Template\" button");
		$I->fillField("#template_code", "Template" . msq("EmailTemplate")); // stepKey: fillTemplateNameFieldCreateDraftTemplate
		$I->fillField("#template_subject", "Template Subject_" . msq("EmailTemplateWithDirectives")); // stepKey: fillTemplateSubjectCreateDraftTemplate
		$I->fillField("#template_text", "Template {{var this.template_id}}:{{var this.getData(template_id)}} Text"); // stepKey: fillTemplateTextCreateDraftTemplate
		$I->comment("Exiting Action Group [createDraftTemplate] PrepareDraftCustomTemplateActionGroup");
		$I->click("#preview"); // stepKey: clickPreviewTemplate
		$I->waitForPageLoad(30); // stepKey: clickPreviewTemplateWaitForPageLoad
		$I->switchToNextTab(); // stepKey: switchToPreviewTab
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/email_template/preview/"); // stepKey: seePreviewInUrl
		$I->seeElement("#preview_iframe"); // stepKey: seeIframeOnPage
		$I->switchToIFrame("preview_iframe"); // stepKey: switchToIframe
		$I->waitForPageLoad(30); // stepKey: waitForPreviewLoaded
		$I->comment("Entering Action Group [assertContent] AssertEmailTemplateContentActionGroup");
		$I->see("Template : Text"); // stepKey: checkTemplateContainTextAssertContent
		$I->comment("Exiting Action Group [assertContent] AssertEmailTemplateContentActionGroup");
	}
}
