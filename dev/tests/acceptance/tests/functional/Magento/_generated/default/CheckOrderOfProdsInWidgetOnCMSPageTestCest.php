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
 * @Title("MC-13718: Checking order of products in a widget on a CMS page - SKU condition")
 * @Description("Checking order of products in a widget on a CMS page - SKU condition<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/CheckOrderOfProdsInWidgetOnCMSPageTest.xml<br>")
 * @TestCaseId("MC-13718")
 * @group Catalog
 */
class CheckOrderOfProdsInWidgetOnCMSPageTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$enableWYSIWYGEnableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled enabled", 60); // stepKey: enableWYSIWYGEnableWYSIWYG
		$I->comment($enableWYSIWYGEnableWYSIWYG);
		$I->comment("Exiting Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$I->comment("Entering Action Group [enableTinyMCE] CliEnableTinyMCEActionGroup");
		$enableTinyMCEEnableTinyMCE = $I->magentoCLI("config:set cms/wysiwyg/editor mage/adminhtml/wysiwyg/tiny_mce/tinymce5Adapter", 60); // stepKey: enableTinyMCEEnableTinyMCE
		$I->comment($enableTinyMCEEnableTinyMCE);
		$I->comment("Exiting Action Group [enableTinyMCE] CliEnableTinyMCEActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitConfigToSave
		$I->createEntity("createFirstCategory", "hook", "ApiCategory", [], []); // stepKey: createFirstCategory
		$I->createEntity("product1", "hook", "ApiSimpleProduct", ["createFirstCategory"], []); // stepKey: product1
		$I->createEntity("product2", "hook", "ApiSimpleProduct", ["createFirstCategory"], []); // stepKey: product2
		$I->createEntity("createCMSPage", "hook", "_defaultCmsPage", [], []); // stepKey: createCMSPage
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
		$I->deleteEntity("createFirstCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("createCMSPage", "hook"); // stepKey: deletePreReqCMSPage
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
	 * @Features({"Cms"})
	 * @Stories({"Widgets"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CheckOrderOfProdsInWidgetOnCMSPageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCreatedCMSPage1] NavigateToCreatedCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCreatedCMSPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSPage1
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSPage1
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSPage1
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSPage1
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToCreatedCMSPage1
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToCreatedCMSPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSPage1
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToCreatedCMSPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSPage1
		$I->comment("Exiting Action Group [navigateToCreatedCMSPage1] NavigateToCreatedCMSPageActionGroup");
		$I->conditionalClick("div[data-index=content]", "div[data-index=content]._show", false); // stepKey: clickContentTab1
		$I->waitForPageLoad(30); // stepKey: waitForContentSectionLoad1
		$I->waitForElementNotVisible("//div[@data-state-collapsible='closed']//span[text()='Content']", 30); // stepKey: waitForTabExpand1
		$I->click("//*[@id='togglecms_page_form_content']"); // stepKey: showHiddenButtons
		$I->seeElement(".action-add-widget"); // stepKey: seeWidgetButton
		$I->click(".action-add-widget"); // stepKey: clickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->see("Inserting a widget does not create a widget instance."); // stepKey: seeMessage
		$I->see("Insert Widget", "//button[@id='insert_button' and contains(@class,'disabled')]"); // stepKey: seeInsertWidgetDisabled
		$I->see("Cancel", "//button[@id='reset' and not(contains(@class,'disabled'))]"); // stepKey: seeCancelBtnEnabled
		$I->selectOption("#select_widget_type", "Catalog Products List"); // stepKey: selectCatalogProductsList
		$I->waitForPageLoad(30); // stepKey: waitBeforeClickingOnAddParamBtn
		$I->click(".rule-param-add"); // stepKey: clickAddParamBtn
		$I->waitForElement("#conditions__1__new_child", 30); // stepKey: addingWaitForConditionsDropDown
		$I->waitForElementVisible("#conditions__1__new_child", 30); // stepKey: waitForDropdownVisible
		$I->selectOption("#conditions__1__new_child", "SKU"); // stepKey: selectCategoryCondition
		$I->waitForPageLoad(30); // stepKey: waitBeforeClickingOnRuleParam
		$I->click("(//span[@class='rule-param']//a)[3]"); // stepKey: clickOnRuleParam1
		$I->waitForElementVisible("//ul[contains(@class,'rule-param-children')]/li[1]//*[contains(@class,'rule-param')][1]//select", 30); // stepKey: waitDropdownToAppear
		$I->selectOption("//ul[contains(@class,'rule-param-children')]/li[1]//*[contains(@class,'rule-param')][1]//select", "is one of"); // stepKey: selectOption
		$I->waitForElement("//a[text()='...']", 30); // stepKey: waitForRuleParam
		$I->click("//a[text()='...']"); // stepKey: clickOnRuleParam
		$I->waitForElementVisible("//img[@title='Open Chooser']", 30); // stepKey: waitForElement
		$I->click("//img[@title='Open Chooser']"); // stepKey: clickChooser
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->fillField("input[name='chooser_name']", $I->retrieveEntityField('product1', 'name', 'test')); // stepKey: fillProduct1Name
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadBeforeClickingOnSearchFilter1
		$I->click("//div[@class='admin__filter-actions']/button[@title='Search']"); // stepKey: searchFilter1
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadBeforeSelectingProduct
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('product1', 'name', 'test') . "')]"); // stepKey: selectProduct1
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFilter1
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadBeforeFillingProductName
		$I->fillField("input[name='chooser_name']", $I->retrieveEntityField('product2', 'name', 'test')); // stepKey: fillProduct2Name
		$I->click("//div[@class='admin__filter-actions']/button[@title='Search']"); // stepKey: clickOnSearch
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadBeforeSelectingProduct2
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('product2', 'name', 'test') . "')]"); // stepKey: selectProduct2
		$I->click(".rule-param-apply"); // stepKey: applyProducts
		$I->comment("Entering Action Group [clickOnInsertWidgetButton] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickOnInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickOnInsertWidgetButtonWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickOnInsertWidgetButton
		$I->comment("Exiting Action Group [clickOnInsertWidgetButton] AdminClickInsertWidgetActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->click("#save-button"); // stepKey: saveWidget
		$I->waitForPageLoad(30); // stepKey: waitForSaveComplete
		$I->comment("Entering Action Group [compareProductOrders1] CompareTwoProductsOrder");
		$I->amOnPage($I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: goToHomePageCompareProductOrders1
		$I->waitForPageLoad(60); // stepKey: waitForPageLoad5CompareProductOrders1
		$clearWidgetCacheCompareProductOrders1 = $I->executeJS("window.localStorage.clear()"); // stepKey: clearWidgetCacheCompareProductOrders1
		$I->reloadPage(); // stepKey: goToHomePageAfterCacheClearedCompareProductOrders1
		$I->waitForPageLoad(60); // stepKey: waitForPageLoad5AfterCacheClearedCompareProductOrders1
		$I->waitForElement("//main//li[1]//img", 120); // stepKey: waitCompareWidgetLoadCompareProductOrders1
		$grabFirstProductName1_1CompareProductOrders1 = $I->grabAttributeFrom("//main//li[1]//img", "alt"); // stepKey: grabFirstProductName1_1CompareProductOrders1
		$I->assertEquals($I->retrieveEntityField('product1', 'name', 'test'), ($grabFirstProductName1_1CompareProductOrders1), "notExpectedOrder"); // stepKey: compare1CompareProductOrders1
		$grabFirstProductName2_2CompareProductOrders1 = $I->grabAttributeFrom("//main//li[2]//img", "alt"); // stepKey: grabFirstProductName2_2CompareProductOrders1
		$I->assertEquals($I->retrieveEntityField('product2', 'name', 'test'), ($grabFirstProductName2_2CompareProductOrders1), "notExpectedOrder"); // stepKey: compare2CompareProductOrders1
		$I->comment("Exiting Action Group [compareProductOrders1] CompareTwoProductsOrder");
		$I->comment("Entering Action Group [navigateToCreatedCMSPage2] NavigateToCreatedCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCreatedCMSPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSPage2
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSPage2
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSPage2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSPage2
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSPage2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSPage2
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectCreatedCMSPageNavigateToCreatedCMSPage2
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: navigateToCreatedCMSPageNavigateToCreatedCMSPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSPage2
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPageNavigateToCreatedCMSPage2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSPage2
		$I->comment("Exiting Action Group [navigateToCreatedCMSPage2] NavigateToCreatedCMSPageActionGroup");
		$I->scrollTo("div[data-index=content]", 0, -80); // stepKey: scrollToContent
		$I->conditionalClick("div[data-index=content]", "div[data-index=content]._show", false); // stepKey: clickContentTab2
		$I->waitForPageLoad(30); // stepKey: waitForContentSectionLoad2
		$I->waitForElementNotVisible("//div[@data-state-collapsible='closed']//span[text()='Content']", 30); // stepKey: waitForTabExpand2
		$setPreviewFrameName = $I->executeJS("jQuery('[id=\'cms_page_form_content_ifr\']').attr('name', 'preview-iframe')"); // stepKey: setPreviewFrameName
		$I->switchToIFrame("preview-iframe"); // stepKey: switchToIframe
		$I->doubleClick("span[class*='magento-widget mceNonEditable']"); // stepKey: clickToEditWidget
		$I->switchToIFrame(); // stepKey: switchOutFromIframe
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadBeforeOpeningProductsList
		$I->click("(//span[@class='rule-param']//a)[4]"); // stepKey: openProductsList
		$I->waitForElementVisible("//img[@title='Open Chooser']", 30); // stepKey: waitForElement2
		$I->click("//img[@title='Open Chooser']"); // stepKey: clickChooser2
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadBeforeFillingProduct1Name
		$I->fillField("input[name='chooser_name']", $I->retrieveEntityField('product1', 'name', 'test')); // stepKey: fillProduct1Name_2
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadBeforeClickingOnSearchFilter2
		$I->click("//div[@class='admin__filter-actions']/button[@title='Search']"); // stepKey: searchFilter2
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadBeforeSelectingProduct1
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('product1', 'name', 'test') . "')]"); // stepKey: selectProduct1_1
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('product1', 'name', 'test') . "')]"); // stepKey: selectProduct2_2
		$I->click(".rule-param-apply"); // stepKey: applyProducts1
		$I->comment("Entering Action Group [clickOnInsertWidgetButton1] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickOnInsertWidgetButton1
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickOnInsertWidgetButton1WaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickOnInsertWidgetButton1
		$I->comment("Exiting Action Group [clickOnInsertWidgetButton1] AdminClickInsertWidgetActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->click("#save-button"); // stepKey: saveWidget1
		$I->waitForPageLoad(30); // stepKey: waitForSaveComplete1
		$I->comment("Entering Action Group [compareProductOrders2] CompareTwoProductsOrder");
		$I->amOnPage($I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: goToHomePageCompareProductOrders2
		$I->waitForPageLoad(60); // stepKey: waitForPageLoad5CompareProductOrders2
		$clearWidgetCacheCompareProductOrders2 = $I->executeJS("window.localStorage.clear()"); // stepKey: clearWidgetCacheCompareProductOrders2
		$I->reloadPage(); // stepKey: goToHomePageAfterCacheClearedCompareProductOrders2
		$I->waitForPageLoad(60); // stepKey: waitForPageLoad5AfterCacheClearedCompareProductOrders2
		$I->waitForElement("//main//li[1]//img", 120); // stepKey: waitCompareWidgetLoadCompareProductOrders2
		$grabFirstProductName1_1CompareProductOrders2 = $I->grabAttributeFrom("//main//li[1]//img", "alt"); // stepKey: grabFirstProductName1_1CompareProductOrders2
		$I->assertEquals($I->retrieveEntityField('product2', 'name', 'test'), ($grabFirstProductName1_1CompareProductOrders2), "notExpectedOrder"); // stepKey: compare1CompareProductOrders2
		$grabFirstProductName2_2CompareProductOrders2 = $I->grabAttributeFrom("//main//li[2]//img", "alt"); // stepKey: grabFirstProductName2_2CompareProductOrders2
		$I->assertEquals($I->retrieveEntityField('product1', 'name', 'test'), ($grabFirstProductName2_2CompareProductOrders2), "notExpectedOrder"); // stepKey: compare2CompareProductOrders2
		$I->comment("Exiting Action Group [compareProductOrders2] CompareTwoProductsOrder");
	}
}
