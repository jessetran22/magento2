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
 * @Title("MAGETWO-84378: Admin should be able to add variable to WYSIWYG content of Block")
 * @Description("You should be able to add variable to WYSIWYG content Block<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminAddVariableToWYSIWYGBlockTest.xml<br>")
 * @TestCaseId("MAGETWO-84378")
 */
class AdminAddVariableToWYSIWYGBlockTestCest
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
		$I->comment("Entering Action Group [amOnEditPage] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridAmOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnEditPage
		$I->comment("Exiting Action Group [amOnEditPage] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilter
		$I->waitForPageLoad(30); // stepKey: waitForGridReload
		$I->deleteEntity("createPreReqBlock", "hook"); // stepKey: deletePreReqBlock
		$I->deleteEntity("createCMSPage", "hook"); // stepKey: deletePreReqCMSPage
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
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddVariableToWYSIWYGBlockTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [assignBlockToCMSPage] AssignBlockToCMSPage");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: amOnEditPageAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignBlockToCMSPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForGridReloadAssignBlockToCMSPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescending1AssignBlockToCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinish1AssignBlockToCMSPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescending2AssignBlockToCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinish1AssignBlockToCMSPage
		$I->waitForElementVisible("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']", 30); // stepKey: waitForCMSPageGridAssignBlockToCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectAssignBlockToCMSPage
		$I->waitForElementVisible("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']", 30); // stepKey: waitForEditLinkAssignBlockToCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: clickEditAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignBlockToCMSPage
		$I->click("div[data-index=content]"); // stepKey: clickContentTabAssignBlockToCMSPage
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCEAssignBlockToCMSPage
		$I->seeElement("button[aria-label='Insert Widget']"); // stepKey: seeWidgetIconAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: seeWidgetIconAssignBlockToCMSPageWaitForPageLoad
		$I->click("button[aria-label='Insert Widget']"); // stepKey: clickInsertWidgetIconAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetIconAssignBlockToCMSPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3AssignBlockToCMSPage
		$I->selectOption("#select_widget_type", "CMS Static Block"); // stepKey: selectCMSStaticBlockAssignBlockToCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading1AssignBlockToCMSPage
		$I->selectOption("select[name='parameters[template]']", "CMS Static Block Default Template"); // stepKey: selectTemplateAssignBlockToCMSPage
		$I->click(".btn-chooser"); // stepKey: clickSelectPageBtnAssignBlockToCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading2AssignBlockToCMSPage
		$I->fillField("//input[@name='chooser_identifier']", $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test')); // stepKey: fillBlockIdentifierAssignBlockToCMSPage
		$I->click("//div[@class='modal-inner-wrap']//button[@title='Search']"); // stepKey: clickSearchBtnAssignBlockToCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinish2AssignBlockToCMSPage
		$I->waitForElementVisible("//td[contains(text(),'" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "')]", 30); // stepKey: waitForBlockTitleAssignBlockToCMSPage
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "')]"); // stepKey: selectPreCreateBlockAssignBlockToCMSPage
		$I->wait(3); // stepKey: wait1AssignBlockToCMSPage
		$I->click("#insert_button"); // stepKey: clickInsertWidgetBtnAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetBtnAssignBlockToCMSPageWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading3AssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad4AssignBlockToCMSPage
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandButtonMenuAssignBlockToCMSPage
		$I->waitForPageLoad(10); // stepKey: expandButtonMenuAssignBlockToCMSPageWaitForPageLoad
		$I->waitForElementVisible("//ul[@data-ui-id='save-button-dropdown-menu']", 30); // stepKey: waitForSplitButtonMenuVisibleAssignBlockToCMSPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonMenuVisibleAssignBlockToCMSPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSavePageAssignBlockToCMSPage
		$I->waitForPageLoad(10); // stepKey: clickSavePageAssignBlockToCMSPageWaitForPageLoad
		$I->comment("Exiting Action Group [assignBlockToCMSPage] AssignBlockToCMSPage");
		$I->comment("Entering Action Group [navigateToCreatedCMSBlockPage1] NavigateToCreatedCMSBlockPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSBlockPage1
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSBlockPage1
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSBlockPage1
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSBlockPage1
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectCreatedCMSBlockNavigateToCreatedCMSBlockPage1
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: navigateToCreatedCMSBlockNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSBlockPage1
		$I->comment("Exiting Action Group [navigateToCreatedCMSBlockPage1] NavigateToCreatedCMSBlockPageActionGroup");
		$I->selectOption("select[name=store_id]", "All Store View"); // stepKey: selectAllStoreView
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCE
		$I->seeElement("button[aria-label='Insert Variable']"); // stepKey: seeInsertVariableIcon
		$I->click("button[aria-label='Insert Variable']"); // stepKey: clickInsertVariableIcon1
		$I->waitForText("Insert Variable", 30); // stepKey: waitForSlideOutOpen
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForPageLoad3
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
		$I->scrollTo("input[name=title]"); // stepKey: scrollToBlockTitle
		$I->waitForElementNotVisible("//h1[contains(text(), 'Insert Variable')]", 30); // stepKey: waitForSlideoutCloses
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
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButton
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveBlock
		$I->waitForPageLoad(10); // stepKey: clickSaveBlockWaitForPageLoad
		$I->comment("Entering Action Group [amOnEditPage] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridAmOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnEditPage
		$I->comment("Exiting Action Group [amOnEditPage] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilter1
		$I->waitForPageLoad(30); // stepKey: waitForFilterReload
		$I->click("//button[text()='Filters']"); // stepKey: clickFiltersBtn
		$I->fillField("//div[@class='admin__form-field-control']/input[@name='identifier']", $I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: fillOutURLKey
		$I->click("//span[text()='Apply Filters']"); // stepKey: clickApplyBtn
		$I->waitForPageLoad(60); // stepKey: clickApplyBtnWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading2
		$I->comment("Entering Action Group [sortByIdDescending] SortByIdDescendingActionGroup");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingSortByIdDescending
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishSortByIdDescending
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingSortByIdDescending
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishSortByIdDescending
		$I->comment("Exiting Action Group [sortByIdDescending] SortByIdDescendingActionGroup");
		$I->waitForElementVisible("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']", 30); // stepKey: waitForCMSPageGrid
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelect
		$I->waitForElementVisible("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']", 30); // stepKey: waitForEditLink
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: clickEdit
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad8
		$I->click("div[data-index=content]"); // stepKey: clickContentTab
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCE1
		$I->seeElement("button[aria-label='Insert Widget']"); // stepKey: seeWidgetIcon
		$I->waitForPageLoad(30); // stepKey: seeWidgetIconWaitForPageLoad
		$I->click("button[aria-label='Insert Widget']"); // stepKey: clickInsertWidgetIcon
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetIconWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad9
		$I->selectOption("#select_widget_type", "CMS Static Block"); // stepKey: selectCMSStaticBlock
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappear
		$I->selectOption("select[name='parameters[template]']", "CMS Static Block Default Template"); // stepKey: selectTemplate
		$I->click(".btn-chooser"); // stepKey: clickSelectPageBtn
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearAfterClickingBtnChooser
		$I->comment("Entering Action Group [sortByIdDescending2] SortByIdDescendingActionGroup");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingSortByIdDescending2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishSortByIdDescending2
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingSortByIdDescending2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishSortByIdDescending2
		$I->comment("Exiting Action Group [sortByIdDescending2] SortByIdDescendingActionGroup");
		$I->waitForElementVisible("//td[contains(text(),'block" . msq("_defaultBlock") . "')]", 30); // stepKey: waitForBlockTitle
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
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilter
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->amOnPage($I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: amOnPageTestPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad11
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
		$I->amOnPage($I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: amOnPageTestPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad12
		$I->comment("see custom variable blank");
		$I->dontSee(" Sample Variable "); // stepKey: dontSeeCustomVariableName
	}
}
