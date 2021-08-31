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
 * @Title("MAGETWO-83504: Admin should be able to insert the default Magento variable into content of WYSIWYG on CMS Pages")
 * @Description("Admin should be able to insert the default Magento variable into content of WYSIWYG on CMS Pages<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminAddVariableToWYSIWYGCMSTest.xml<br>")
 * @TestCaseId("MAGETWO-83504")
 */
class AdminAddVariableToWYSIWYGCMSTestCest
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
	 * @Stories({"MAGETWO-42158-Variable with WYSIWYG"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddVariableToWYSIWYGCMSTest(AcceptanceTester $I)
	{
		$I->comment("Create Custom Variable");
		$I->comment("Entering Action Group [createCustomVariable] CreateCustomVariableActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_variable/new/"); // stepKey: goToNewCustomVarialePageCreateCustomVariable
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCreateCustomVariable
		$I->fillField("#code", "variable-code" . msq("customVariable")); // stepKey: fillVariableCodeCreateCustomVariable
		$I->fillField("#name", "Test Variable"); // stepKey: fillVariableNameCreateCustomVariable
		$I->fillField("#html_value", " Sample Variable "); // stepKey: fillVariableHtmlCreateCustomVariable
		$I->fillField("#plain_value", "variable-plain-"); // stepKey: fillVariablePlainCreateCustomVariable
		$I->click("#save"); // stepKey: clickSaveVariableCreateCustomVariable
		$I->comment("Exiting Action Group [createCustomVariable] CreateCustomVariableActionGroup");
		$I->comment("Setup Store information");
		$I->waitForPageLoad(30); // stepKey: wait
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/"); // stepKey: goToConfigStoreInformation
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->conditionalClick("#general_store_information-head", "#general_store_information-head:not(.open)", true); // stepKey: checkIfTabOpen
		$I->fillField("#general_store_information_city", " Austin "); // stepKey: fillCity
		$I->click("#save"); // stepKey: saveConfig
		$I->waitForPageLoad(30); // stepKey: saveConfigWaitForPageLoad
		$I->comment("Main test");
		$I->comment("Entering Action Group [navigateToPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageNavigateToPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadNavigateToPage
		$I->comment("Exiting Action Group [navigateToPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->fillField("input[name=title]", "Test CMS Page"); // stepKey: fillFieldTitle
		$I->click("div[data-index=content]"); // stepKey: clickContentTab
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCE
		$executeJSFillContent = $I->executeJS("tinyMCE.activeEditor.setContent('Hello CMS Page!');"); // stepKey: executeJSFillContent
		$I->seeElement("button[aria-label='Insert Variable']"); // stepKey: seeInsertVariableIcon
		$I->click("button[aria-label='Insert Variable']"); // stepKey: clickInsertVariableIcon1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForPageLoad3
		$I->waitForText("Insert Variable", 30); // stepKey: waitForSlideOutOpen
		$I->comment("see Insert Variable button disabled");
		$I->see("Insert Variable", "//button[@id='insert_variable' and contains(@class,'disabled')]"); // stepKey: seeInsertWidgetDisabled
		$I->comment("see Cancel button enabled");
		$I->see("Cancel", "//button[@class='action-scalable cancel' and not(contains(@class,'disabled'))]"); // stepKey: seeCancelBtnEnabled
		$I->comment("see 4 columns");
		$I->see("Select", "//table[@class='data-grid data-grid-draggable']/thead/tr/th/span[text()='Select']"); // stepKey: selectCol
		$I->see("Variable Name", "//table[@class='data-grid data-grid-draggable']/thead/tr/th/span[text()='Variable Name']"); // stepKey: variableCol
		$I->see("Type", "//table[@class='data-grid data-grid-draggable']/thead/tr/th/span[text()='Type']"); // stepKey: typeCol
		$I->see("Code", "//table[@class='data-grid data-grid-draggable']/thead/tr/th/span[text()='Code']"); // stepKey: codeCol
		$I->comment("select default variable");
		$I->click("//input[@type='radio' and contains(@value, 'city')]"); // stepKey: selectDefaultVariable
		$I->see("Insert Variable", "//button[@id='insert_variable' and not(contains(@class,'disabled'))]"); // stepKey: seeInsertVarialeEnabled
		$I->click("//button[@id='insert_variable' and not(contains(@class,'disabled'))]"); // stepKey: save1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad8
		$I->click("button[aria-label='Insert Variable']"); // stepKey: clickInsertVariableIcon2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad4
		$I->comment("see custom variable");
		$I->see("variable-code" . msq("customVariable")); // stepKey: seeCustomVariable
		$I->seeElement("input[placeholder='Search by keyword']"); // stepKey: searchBox
		$I->comment("press Enter");
		$I->pressKey("input[placeholder='Search by keyword']", 'Test Variable',\Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: pressKeyEnter
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad5
		$I->comment("see result");
		$I->see("variable-code" . msq("customVariable"), "//table/tbody/tr//td/div[text()='variable-code" . msq("customVariable") . "']"); // stepKey: seeResult
		$I->comment("Insert custom variable");
		$I->click("//div[text()='variable-code" . msq("customVariable") . "']/parent::td//preceding-sibling::td/input[@type='radio']"); // stepKey: selectCustomVariable1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad6
		$I->click("//button[@id='insert_variable' and not(contains(@class,'disabled'))]"); // stepKey: save2
		$I->waitForElementNotVisible("//h1[contains(text(), 'Insert Variable')]", 30); // stepKey: waitForSlideOutClose
		$I->click(".scalable.action-show-hide"); // stepKey: clickShowHideBtn
		$I->waitForElementVisible(".scalable.add-variable.plugin", 30); // stepKey: waitForInsertVariableBtn
		$I->seeElement(".scalable.add-variable.plugin"); // stepKey: InsertVariableBtn
		$I->scrollTo("div[data-index=search_engine_optimisation]"); // stepKey: scrollToSearchEngineTab
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineTabWaitForPageLoad
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
		$I->amOnPage("test-page-" . msq("_defaultCmsPage")); // stepKey: amOnPageTestPage
		$I->comment("see Default Variable on Storefront");
		$I->see(" Austin "); // stepKey: seeDefaultVariable
		$I->comment("see Custom Variable on Storefront");
		$I->see(" Sample Variable "); // stepKey: seeCustomVariable2
		$I->comment("Delete Custom Variable");
		$I->comment("Entering Action Group [deleteCustomVariable] DeleteCustomVariableActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_variable/index/"); // stepKey: goToVarialeGridDeleteCustomVariable
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteCustomVariable
		$I->click(".//*[@id='customVariablesGrid_table']/tbody//tr//td[contains(text(), 'variable-code" . msq("customVariable") . "')]"); // stepKey: goToCustomVariableEditPageDeleteCustomVariable
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteCustomVariable
		$I->waitForElementVisible("#delete", 30); // stepKey: waitForDeleteBtnDeleteCustomVariable
		$I->click("#delete"); // stepKey: deleteCustomVariableDeleteCustomVariable
		$I->waitForText("Are you sure you want to do this?", 30); // stepKey: waitForTextDeleteCustomVariable
		$I->click(".action-primary.action-accept"); // stepKey: confirmDeleteDeleteCustomVariable
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3DeleteCustomVariable
		$I->comment("Exiting Action Group [deleteCustomVariable] DeleteCustomVariableActionGroup");
		$I->comment("Entering Action Group [clearCache] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementClearCache
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCache
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheClearCache
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushClearCache
		$I->comment("Exiting Action Group [clearCache] ClearCacheActionGroup");
		$I->comment("Refresh Storefront");
		$I->amOnPage("test-page-" . msq("_defaultCmsPage")); // stepKey: amOnPageTestPageRefresh
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad7
		$I->comment("see custom variable blank");
		$I->dontSee(" Sample Variable "); // stepKey: dontSeeCustomVariableName
	}
}
