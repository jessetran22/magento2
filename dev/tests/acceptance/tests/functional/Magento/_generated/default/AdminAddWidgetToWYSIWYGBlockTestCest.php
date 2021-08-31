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
 * @Title("MAGETWO-84654: Admin should be able to add widget to WYSIWYG content of Block")
 * @Description("Admin should be able to add widget to WYSIWYG content Block<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminAddWidgetToWYSIWYGBlockTest.xml<br>")
 * @TestCaseId("MAGETWO-84654")
 */
class AdminAddWidgetToWYSIWYGBlockTestCest
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
		$I->createEntity("createCMSPage", "hook", "_defaultCmsPage", [], []); // stepKey: createCMSPage
		$I->createEntity("createPreReqBlock", "hook", "_defaultBlock", [], []); // stepKey: createPreReqBlock
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
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
		$I->comment("Entering Action Group [amOnEditPage] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridAmOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnEditPage
		$I->comment("Exiting Action Group [amOnEditPage] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilter
		$I->waitForPageLoad(30); // stepKey: waitForGridReload
		$I->deleteEntity("createCMSPage", "hook"); // stepKey: deletePreReqCMSPage
		$I->deleteEntity("createPreReqBlock", "hook"); // stepKey: deletePreReqBlock
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
	 * @Stories({"MAGETWO-42156-Apply new WYSIWYG in Block"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddWidgetToWYSIWYGBlockTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCreatedCMSBlockPage] NavigateToCreatedCMSBlockPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCreatedCMSBlockPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSBlockPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSBlockPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSBlockPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSBlockPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSBlockPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectCreatedCMSBlockNavigateToCreatedCMSBlockPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: navigateToCreatedCMSBlockNavigateToCreatedCMSBlockPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSBlockPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSBlockPage
		$I->comment("Exiting Action Group [navigateToCreatedCMSBlockPage] NavigateToCreatedCMSBlockPageActionGroup");
		$I->selectOption("select[name=store_id]", "All Store View"); // stepKey: selectAllStoreView
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCE
		$I->click("button[aria-label='Insert Widget']"); // stepKey: clickInsertWidgetIcon1
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetIcon1WaitForPageLoad
		$I->wait(10); // stepKey: waitForPageLoad2
		$I->see("Inserting a widget does not create a widget instance."); // stepKey: seeMessage
		$I->selectOption("#select_widget_type", "CMS Page Link"); // stepKey: selectCMSPageLink
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappear1
		$I->see("Insert Widget", "//button[@id='insert_button' and not(contains(@class,'disabled'))]"); // stepKey: seeInsertWidgetEnabled
		$I->selectOption("select[name='parameters[template]']", "CMS Page Link Block Template"); // stepKey: selectTemplate1
		$I->click(".btn-chooser"); // stepKey: clickSelectPageBtn1
		$I->waitForElementVisible("//td[contains(text(),'Home page')]", 30); // stepKey: waitForPageVisible
		$I->click("//td[contains(text(),'Home page')]"); // stepKey: selectPreCreateCMS
		$I->waitForElementNotVisible("//h1[contains(text(),'Select Page')]", 30); // stepKey: waitForSlideOutCloses
		$I->comment("Entering Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickInsertWidget
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickInsertWidgetWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickInsertWidget
		$I->comment("Exiting Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButton
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveBlock
		$I->waitForPageLoad(10); // stepKey: clickSaveBlockWaitForPageLoad
		$I->comment("Entering Action Group [navigateToCreatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToCreatedCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToCreatedCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSPage
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToCreatedCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSPage
		$I->comment("Exiting Action Group [navigateToCreatedCMSPage] NavigateToCreatedCMSPageActionGroup");
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCE1
		$I->seeElement("button[aria-label='Insert Widget']"); // stepKey: seeWidgetIcon
		$I->waitForPageLoad(30); // stepKey: seeWidgetIconWaitForPageLoad
		$I->click("button[aria-label='Insert Widget']"); // stepKey: clickInsertWidgetIcon2
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetIcon2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad5
		$I->selectOption("#select_widget_type", "CMS Static Block"); // stepKey: selectCMSStaticBlock
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappear2
		$I->selectOption("select[name='parameters[template]']", "CMS Static Block Default Template"); // stepKey: selectTemplate2
		$I->click(".btn-chooser"); // stepKey: clickSelectPageBtn2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForWidgetChooserLoadingMaskToDisappear
		$I->comment("Entering Action Group [searchBlockOnGridPage] searchBlockOnGridPage");
		$I->fillField("//input[@name='chooser_identifier']", "block" . msq("_defaultBlock")); // stepKey: fillEntityIdentifierSearchBlockOnGridPage
		$I->click("//div[@class='modal-inner-wrap']//button[@title='Search']"); // stepKey: clickSearchBtnSearchBlockOnGridPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinish2SearchBlockOnGridPage
		$I->waitForElementVisible("//td[contains(text(),'block" . msq("_defaultBlock") . "')]", 30); // stepKey: waitForBlockTitleSearchBlockOnGridPage
		$I->comment("Exiting Action Group [searchBlockOnGridPage] searchBlockOnGridPage");
		$I->click("//td[contains(text(),'block" . msq("_defaultBlock") . "')]"); // stepKey: selectPreCreateBlock
		$I->wait(3); // stepKey: wait1
		$I->comment("Entering Action Group [clickInsertWidgetBtn] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickInsertWidgetBtn
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickInsertWidgetBtnWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickInsertWidgetBtn
		$I->comment("Exiting Action Group [clickInsertWidgetBtn] AdminClickInsertWidgetActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
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
		$I->comment("Entering Action Group [clearCache] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementClearCache
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCache
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheClearCache
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushClearCache
		$I->comment("Exiting Action Group [clearCache] ClearCacheActionGroup");
		$I->amOnPage($I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: amOnPageTestPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad7
		$I->see("Home page"); // stepKey: seeHomePageCMSPage
	}
}
