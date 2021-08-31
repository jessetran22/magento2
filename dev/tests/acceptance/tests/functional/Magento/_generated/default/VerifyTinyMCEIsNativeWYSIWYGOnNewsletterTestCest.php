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
 * @group Newsletter
 * @Title("MAGETWO-84683: Admin should see TinyMCE is the native WYSIWYG on Newsletter")
 * @Description("Admin should see TinyMCE is the native WYSIWYG on Newsletter<h3>Test files</h3>app/code/Magento/Newsletter/Test/Mftf/Test/VerifyTinyMCEIsNativeWYSIWYGOnNewsletterTest.xml<br>")
 * @TestCaseId("MAGETWO-84683")
 */
class VerifyTinyMCEIsNativeWYSIWYGOnNewsletterTestCest
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
		$I->comment("Entering Action Group [loginGetFromGeneralFile] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginGetFromGeneralFile
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginGetFromGeneralFile
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginGetFromGeneralFile
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginGetFromGeneralFile
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginGetFromGeneralFileWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginGetFromGeneralFile
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginGetFromGeneralFile
		$I->comment("Exiting Action Group [loginGetFromGeneralFile] AdminLoginActionGroup");
		$I->comment("Entering Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$enableWYSIWYGEnableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled enabled", 60); // stepKey: enableWYSIWYGEnableWYSIWYG
		$I->comment($enableWYSIWYGEnableWYSIWYG);
		$I->comment("Exiting Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$I->comment("Entering Action Group [enableTinyMCE] CliEnableTinyMCEActionGroup");
		$enableTinyMCEEnableTinyMCE = $I->magentoCLI("config:set cms/wysiwyg/editor mage/adminhtml/wysiwyg/tiny_mce/tinymce5Adapter", 60); // stepKey: enableTinyMCEEnableTinyMCE
		$I->comment($enableTinyMCEEnableTinyMCE);
		$I->comment("Exiting Action Group [enableTinyMCE] CliEnableTinyMCEActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
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
	 * @Features({"Newsletter"})
	 * @Stories({"MAGETWO-47309-Apply new WYSIWYG in Newsletter"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VerifyTinyMCEIsNativeWYSIWYGOnNewsletterTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/newsletter/template/new/"); // stepKey: amOnNewsletterTemplatePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->fillField("#code", "Test Newsletter Template" . msq("_defaultNewsletter")); // stepKey: fillTemplateName
		$I->fillField("#subject", "Test Newsletter Subject"); // stepKey: fillTemplateSubject
		$I->fillField("#sender_name", "Admin"); // stepKey: fillSenderName
		$I->fillField("#sender_email", "admin@magento.com"); // stepKey: fillSenderEmail
		$I->conditionalClick("#toggletext", ".tox-tinymce", false); // stepKey: clickBtnIfTinyMCEHidden
		$I->waitForPageLoad(30); // stepKey: waitForTinyMce
		$I->comment("Entering Action Group [verifyTinyMCE] VerifyTinyMCEActionGroup");
		$I->seeElement("button[title='Blocks']"); // stepKey: assertInfo2VerifyTinyMCE
		$I->seeElement("button[title='Bold']"); // stepKey: assertInfo3VerifyTinyMCE
		$I->seeElement("button[title='Italic']"); // stepKey: assertInfo4VerifyTinyMCE
		$I->seeElement("button[title='Underline']"); // stepKey: assertInfo5VerifyTinyMCE
		$I->seeElement("button[title='Align left']"); // stepKey: assertInfo6VerifyTinyMCE
		$I->seeElement("button[title='Align center']"); // stepKey: assertInfo7VerifyTinyMCE
		$I->seeElement("button[title='Align right']"); // stepKey: assertInfo8VerifyTinyMCE
		$I->seeElement("div[title='Numbered list']"); // stepKey: assertInfo9VerifyTinyMCE
		$I->seeElement("div[title='Bullet list']"); // stepKey: assertInfo10VerifyTinyMCE
		$I->seeElement("button[title='Insert/edit link']"); // stepKey: assertInfo11VerifyTinyMCE
		$I->seeElement("button[title='Insert/edit image']"); // stepKey: assertInf12VerifyTinyMCE
		$I->waitForPageLoad(30); // stepKey: assertInf12VerifyTinyMCEWaitForPageLoad
		$I->seeElement("button[title='Table']"); // stepKey: assertInfo13VerifyTinyMCE
		$I->seeElement("button[title='Special character']"); // stepKey: assertInfo14VerifyTinyMCE
		$I->comment("Exiting Action Group [verifyTinyMCE] VerifyTinyMCEActionGroup");
		$I->comment("Entering Action Group [verifyMagentoEntities] VerifyMagentoEntityActionGroup");
		$I->seeElement("button[aria-label='Insert Widget']"); // stepKey: assertInfo15VerifyMagentoEntities
		$I->waitForPageLoad(30); // stepKey: assertInfo15VerifyMagentoEntitiesWaitForPageLoad
		$I->seeElement("button[aria-label='Insert Variable']"); // stepKey: assertInfo16VerifyMagentoEntities
		$I->comment("Exiting Action Group [verifyMagentoEntities] VerifyMagentoEntityActionGroup");
		$executeJSFillContent = $I->executeJS("tinyMCE.get('text').setContent('Hello World From Newsletter Template!');"); // stepKey: executeJSFillContent
		$I->click(".scalable.action-show-hide"); // stepKey: clickShowHideBtn2
		$I->waitForElementVisible(".action-add-widget", 30); // stepKey: waitForInsertWidget
		$I->see("Insert Image...", ".scalable.action-add-image.plugin"); // stepKey: assertInf17
		$I->see("Insert Widget...", ".action-add-widget"); // stepKey: assertInfo18
		$I->see("Insert Variable...", ".scalable.add-variable.plugin"); // stepKey: assertInfo19
		$I->comment("Go to Storefront");
		$I->click("button[data-role='template-save']"); // stepKey: clickSavePage
		$I->waitForPageLoad(60); // stepKey: clickSavePageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3
		$I->click("//td[contains(text(),'Test Newsletter Template" . msq("_defaultNewsletter") . "')]//following-sibling::td/select//option[contains(text(), 'Preview')]"); // stepKey: clickPreview
		$I->waitForPageLoad(60); // stepKey: clickPreviewWaitForPageLoad
		$I->switchToWindow("action_window"); // stepKey: switchToWindow
		$I->comment("Entering Action Group [switchToIframe] SwitchToPreviewIframeActionGroup");
		$addSandboxValueSwitchToIframe = $I->executeJS("document.getElementById('preview_iframe').sandbox.add('allow-scripts')"); // stepKey: addSandboxValueSwitchToIframe
		$I->wait(10); // stepKey: waitBeforeSwitchToIframeSwitchToIframe
		$I->switchToIFrame("preview_iframe"); // stepKey: switchToIframeSwitchToIframe
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToIframe
		$I->comment("Exiting Action Group [switchToIframe] SwitchToPreviewIframeActionGroup");
		$I->waitForText("Hello World From Newsletter Template!", 30); // stepKey: waitForPageLoad2
		$I->see("Hello World From Newsletter Template!"); // stepKey: seeContent
		$I->closeTab(); // stepKey: closeTab
	}
}
