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
 * @group Cms
 * @Title("MAGETWO-84182: Admin should see TinyMCE is the native WYSIWYG on CMS Page")
 * @Description("Admin should see TinyMCE is the native WYSIWYG on CMS Page<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/VerifyTinyMCEIsNativeWYSIWYGOnCMSPageTest.xml<br>")
 * @TestCaseId("MAGETWO-84182")
 */
class VerifyTinyMCEIsNativeWYSIWYGOnCMSPageTestCest
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
	 * @Features({"Cms"})
	 * @Stories({"MAGETWO-42046-Apply new WYSIWYG on CMS Page"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VerifyTinyMCEIsNativeWYSIWYGOnCMSPageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnPagePagesGrid] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridAmOnPagePagesGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnPagePagesGrid
		$I->comment("Exiting Action Group [amOnPagePagesGrid] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickAddNewPage] AdminClickAddNewPageOnPagesGridActionGroup");
		$I->click("#add"); // stepKey: clickAddNewPageClickAddNewPage
		$I->waitForPageLoad(30); // stepKey: clickAddNewPageClickAddNewPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickAddNewPage
		$I->comment("Exiting Action Group [clickAddNewPage] AdminClickAddNewPageOnPagesGridActionGroup");
		$I->fillField("input[name=title]", "Test CMS Page"); // stepKey: fillFieldTitle
		$I->click("div[data-index=content]"); // stepKey: clickExpandContent
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillFieldContentHeading
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCE
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
		$executeJSFillContent = $I->executeJS("tinyMCE.get('cms_page_form_content').setContent('Hello World!');"); // stepKey: executeJSFillContent
		$I->click(".scalable.action-show-hide"); // stepKey: clickShowHideBtn
		$I->waitForElementVisible(".action-add-widget", 30); // stepKey: waitForInsertWidget
		$I->see("Insert Image...", ".scalable.action-add-image.plugin"); // stepKey: assertInf17
		$I->see("Insert Widget...", ".action-add-widget"); // stepKey: assertInfo18
		$I->see("Insert Variable...", ".scalable.add-variable.plugin"); // stepKey: assertInfo19
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisation
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationWaitForPageLoad
		$I->fillField("input[name=identifier]", "test-page-" . msq("_defaultCmsPage")); // stepKey: fillFieldUrlKey
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickSavePage] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonClickSavePage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonClickSavePageWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonClickSavePage
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonClickSavePageWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageClickSavePage
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageClickSavePageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageClickSavePage
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageClickSavePageWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonClickSavePage
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonClickSavePageWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSavePage
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageClickSavePage
		$I->comment("Exiting Action Group [clickSavePage] SaveCmsPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->amOnPage("test-page-" . msq("_defaultCmsPage")); // stepKey: amOnPageTestPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->see("Test Content Heading"); // stepKey: seeContentHeading
		$I->see("Hello World!"); // stepKey: seeContent
	}
}
