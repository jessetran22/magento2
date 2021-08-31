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
 * @group Catalog
 * @Title("MC-6215: Admin are able to change Input Type of Text Editor product attribute")
 * @Description("Admin are able to change Input Type of Text Editor product attribute<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminEditTextEditorProductAttributeTest.xml<br>")
 * @TestCaseId("MC-6215")
 */
class AdminEditTextEditorProductAttributeTestCest
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
		$I->createEntity("myProductAttributeCreation", "hook", "productAttributeWysiwyg", [], []); // stepKey: myProductAttributeCreation
		$I->createEntity("myProductAttributeSetAssign", "hook", "AddToDefaultSet", ["myProductAttributeCreation"], []); // stepKey: myProductAttributeSetAssign
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("myProductAttributeCreation", "hook"); // stepKey: deletePreReqProductAttribute
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
	 * @Features({"Catalog"})
	 * @Stories({"MAGETWO-51484-Input type configuration for custom Product Attributes"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEditTextEditorProductAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToAttribute] NavigateToCreatedProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridNavigateToAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersNavigateToAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersNavigateToAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "attribute" . msq("productAttributeWysiwyg")); // stepKey: setAttributeCodeNavigateToAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridNavigateToAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridNavigateToAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowNavigateToAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowNavigateToAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToAttribute
		$I->comment("Exiting Action Group [navigateToAttribute] NavigateToCreatedProductAttributeActionGroup");
		$I->seeOptionIsSelected("#frontend_input", "Text Editor"); // stepKey: seeTextEditorSelected
		$I->see("Text Area", "#frontend_input"); // stepKey: seeTextArea1
		$I->selectOption("#frontend_input", "Text Area"); // stepKey: selectTextArea
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTab1
		$I->dontSeeElement("#enabled"); // stepKey: dontSeeWYSIWYGEnableField1
		$I->click("#save"); // stepKey: saveAttribute1
		$I->waitForPageLoad(30); // stepKey: saveAttribute1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: navigateToNewProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad4
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillName
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPrice
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKU
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantity
		$I->dontSeeElement("div[data-index='" . $I->retrieveEntityField('myProductAttributeCreation', 'attribute_code', 'test') . "'] .tox-tinymce"); // stepKey: dontSeeTinyMCE
		$I->fillField("div[data-index='" . $I->retrieveEntityField('myProductAttributeCreation', 'attribute_code', 'test') . "'] textarea", "Text Area"); // stepKey: fillContentTextarea
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->comment("Go to storefront product page, assert product content");
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: navigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad5
		$I->see("Text Area"); // stepKey: seeText2
		$I->comment("Entering Action Group [navigateToProductAttributeGrid2] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageNavigateToProductAttributeGrid2
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadNavigateToProductAttributeGrid2
		$I->comment("Exiting Action Group [navigateToProductAttributeGrid2] AdminOpenProductAttributePageActionGroup");
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('myProductAttributeCreation', 'attribute_code', 'test') . "')]"); // stepKey: navigateToAttributeEditPage2
		$I->waitForPageLoad(30); // stepKey: navigateToAttributeEditPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad7
		$I->seeOptionIsSelected("#frontend_input", "Text Area"); // stepKey: seeTextAreaSelected
		$I->see("Text Editor", "#frontend_input"); // stepKey: seeTextEditor
		$I->selectOption("#frontend_input", "Text Editor"); // stepKey: selectEditor
		$I->see("Text Editor input type requires WYSIWYG to be enabled in Stores > Configuration > Content Management."); // stepKey: seeHintMsg
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTab2
		$I->dontSeeElement("#enabled"); // stepKey: dontSeeWYSIWYGEnableField2
		$I->click("#save"); // stepKey: saveAttribute8
		$I->waitForPageLoad(30); // stepKey: saveAttribute8WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad8
		$I->comment("Entering Action Group [amOnProductGrid] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGrid
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGrid
		$I->comment("Exiting Action Group [amOnProductGrid] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [sortByIdDescending] SortByIdDescendingActionGroup");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingSortByIdDescending
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishSortByIdDescending
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingSortByIdDescending
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishSortByIdDescending
		$I->comment("Exiting Action Group [sortByIdDescending] SortByIdDescendingActionGroup");
		$I->conditionalClick(".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clearAllExistingFilter
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingAfterFilterIsCleared
		$I->fillField(".admin__control-text.data-grid-search-control", "testProductName" . msq("_defaultProduct")); // stepKey: addSearchFilterForTestProduct
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickOnBasicSearchFilterButton
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingAfterBasicFilter
		$I->click("//div[text()='testProductName" . msq("_defaultProduct") . "']"); // stepKey: navigateToEditProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad10
		$I->seeElement("div[data-index='" . $I->retrieveEntityField('myProductAttributeCreation', 'attribute_code', 'test') . "'] .tox-tinymce"); // stepKey: seePoweredBy
	}
}
