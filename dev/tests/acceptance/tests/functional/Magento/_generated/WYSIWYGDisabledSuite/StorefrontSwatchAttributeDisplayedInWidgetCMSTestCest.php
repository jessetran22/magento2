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
 * @Title("MC-28607: Swatch Attribute is displayed in the Widget CMS")
 * @Description("Swatch Attribute is displayed in the Widget CMS<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/StorefrontSwatchAttributeDisplayedInWidgetCMSTest.xml<br>")
 * @TestCaseId("MC-28607")
 * @group configurableProduct
 * @group cms
 * @group widget
 * @group swatch
 * @group WYSIWYGDisabled
 */
class StorefrontSwatchAttributeDisplayedInWidgetCMSTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create Configurable product");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigurableProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigurableProduct
		$I->comment("Create product swatch attribute with 1 variations");
		$I->createEntity("createVisualSwatchAttribute", "hook", "VisualSwatchProductAttributeForm", [], []); // stepKey: createVisualSwatchAttribute
		$I->createEntity("swatchAttributeOption", "hook", "SwatchProductAttributeOption1", ["createVisualSwatchAttribute"], []); // stepKey: swatchAttributeOption
		$I->comment("Create CMS Page");
		$I->createEntity("createCmsPage", "hook", "_defaultCmsPage", [], []); // stepKey: createCmsPage
		$I->comment("Login to Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Open configurable product edit page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigurableProduct', 'id', 'hook')); // stepKey: goToConfigurableProduct
		$I->comment("Add attributes to configurable product");
		$I->conditionalClick(".admin__collapsible-block-wrapper[data-index='configurable']", "button[data-index='create_configurable_products_button']", false); // stepKey: openConfigurationSection
		$I->waitForPageLoad(30); // stepKey: openConfigurationSectionWaitForPageLoad
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: openConfigurationPanel
		$I->waitForPageLoad(30); // stepKey: openConfigurationPanelWaitForPageLoad
		$I->comment("Find Swatch attribute in grid and select it");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearAttributeGridFiltersToFindSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: clearAttributeGridFiltersToFindSwatchAttributeWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersPaneForSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: openFiltersPaneForSwatchAttributeWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='attribute_code']", $I->retrieveEntityField('createVisualSwatchAttribute', 'attribute_code', 'hook')); // stepKey: fillAttributeCodeFilterFieldForSwatchAttribute
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonForSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonForSwatchAttributeWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1) td.data-grid-checkbox-cell input"); // stepKey: selectSwatchAttribute
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextToSelectOptions
		$I->waitForPageLoad(30); // stepKey: clickNextToSelectOptionsWaitForPageLoad
		$I->click("//div[@data-attribute-title='" . $I->retrieveEntityField('createVisualSwatchAttribute', 'frontend_label[0]', 'hook') . "']//button[contains(@class, 'action-select-all')]"); // stepKey: selectAllSwatchAttributeOptions
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextToApplyQuantity
		$I->waitForPageLoad(30); // stepKey: clickNextToApplyQuantityWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "100"); // stepKey: enterAttributeQuantity
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextToProceedToSummary
		$I->waitForPageLoad(30); // stepKey: clickOnNextToProceedToSummaryWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickGenerateProductsButton
		$I->waitForPageLoad(30); // stepKey: clickGenerateProductsButtonWaitForPageLoad
		$I->comment("Save Product");
		$I->comment("Entering Action Group [saveConfigurableProduct] SaveConfigurableProductAddToCurrentAttributeSetActionGroup");
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveBtnVisibleSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveBtnVisibleSaveConfigurableProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: saveProductAgainSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: saveProductAgainSaveConfigurableProductWaitForPageLoad
		$I->waitForElementVisible("button[data-index='confirm_button']", 30); // stepKey: waitPopUpVisibleSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitPopUpVisibleSaveConfigurableProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmPopupSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmPopupSaveConfigurableProductWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSaveProductMessageSaveConfigurableProduct
		$I->comment("Exiting Action Group [saveConfigurableProduct] SaveConfigurableProductAddToCurrentAttributeSetActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Open edit CMS Page");
		$I->comment("Entering Action Group [openEditCmsPage] AdminOpenCmsPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/edit/page_id/" . $I->retrieveEntityField('createCmsPage', 'id', 'hook')); // stepKey: openEditCmsPageOpenEditCmsPage
		$I->comment("Exiting Action Group [openEditCmsPage] AdminOpenCmsPageActionGroup");
		$I->conditionalClick("//div[@class='fieldset-wrapper-title']//span[.='Content']", "//*[@id='togglecms_page_form_content']", false); // stepKey: expandContentSectionIfNotVisible
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadContentSection
		$I->conditionalClick("//*[@id='togglecms_page_form_content']", ".scalable.action-add-widget.plugin", false); // stepKey: clickNextShowHideEditorIfVisible
		$I->comment("Insert Widget");
		$I->comment("Entering Action Group [insertWidgetToCmsPageContent] AdminInsertWidgetToCmsPageContentActionGroup");
		$I->waitForElementVisible("//span[contains(text(),'Insert Widget...')]", 30); // stepKey: waitForInsertWidgetElementVisibleInsertWidgetToCmsPageContent
		$I->click("//span[contains(text(),'Insert Widget...')]"); // stepKey: clickOnInsertWidgetButtonInsertWidgetToCmsPageContent
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterClickOnInsertWidgetButtonInsertWidgetToCmsPageContent
		$I->waitForElementVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForInsertWidgetTitleInsertWidgetToCmsPageContent
		$I->selectOption("#select_widget_type", "Catalog Products List"); // stepKey: selectWidgetTypeInsertWidgetToCmsPageContent
		$I->comment("Exiting Action Group [insertWidgetToCmsPageContent] AdminInsertWidgetToCmsPageContentActionGroup");
		$I->comment("Entering Action Group [fillCatalogProductsListWidgetOptions] AdminFillCatalogProductsListWidgetCategoryActionGroup");
		$I->waitForElementVisible(".rule-param-add", 30); // stepKey: waitForAddParamElementFillCatalogProductsListWidgetOptions
		$I->click(".rule-param-add"); // stepKey: clickOnAddParamElementFillCatalogProductsListWidgetOptions
		$I->waitForElementVisible("#conditions__1__new_child", 30); // stepKey: waitForConditionsDropdownVisibleFillCatalogProductsListWidgetOptions
		$I->selectOption("#conditions__1__new_child", "Category"); // stepKey: selectCategoryAsConditionFillCatalogProductsListWidgetOptions
		$I->waitForElementVisible("//a[text()='...']", 30); // stepKey: waitForRuleParamElementVisibleFillCatalogProductsListWidgetOptions
		$I->click("//a[text()='...']"); // stepKey: clickToAddRuleParamFillCatalogProductsListWidgetOptions
		$I->click("//img[@title='Open Chooser']"); // stepKey: clickToSelectFromListFillCatalogProductsListWidgetOptions
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterSelectingRuleParamFillCatalogProductsListWidgetOptions
		$I->waitForElementVisible(" //span[contains(text(),'" . $I->retrieveEntityField('createCategory', 'name', 'hook') . "')]", 30); // stepKey: waitForCategoryElementVisibleFillCatalogProductsListWidgetOptions
		$I->click(" //span[contains(text(),'" . $I->retrieveEntityField('createCategory', 'name', 'hook') . "')]"); // stepKey: selectCategoryFromArgumentsFillCatalogProductsListWidgetOptions
		$I->click(".rule-param-apply"); // stepKey: clickApplyButtonFillCatalogProductsListWidgetOptions
		$I->waitForElementNotVisible(".rule-chooser .tree.x-tree", 30); // stepKey: waitForCategoryTreeIsNotVisibleFillCatalogProductsListWidgetOptions
		$I->comment("Exiting Action Group [fillCatalogProductsListWidgetOptions] AdminFillCatalogProductsListWidgetCategoryActionGroup");
		$I->comment("Entering Action Group [clickInsertWidgetButton] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickInsertWidgetButtonWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickInsertWidgetButton
		$I->comment("Exiting Action Group [clickInsertWidgetButton] AdminClickInsertWidgetActionGroup");
		$I->comment("Save CMS Page");
		$I->comment("Entering Action Group [saveCmsPage] AdminSaveAndContinueEditCmsPageActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageSaveCmsPage
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveAndContinueButtonSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSaveAndContinueButtonSaveCmsPageWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveAndContinueButtonSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: clickSaveAndContinueButtonSaveCmsPageWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveCmsPage
		$I->see("You saved the page.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveCmsPage
		$I->comment("Exiting Action Group [saveCmsPage] AdminSaveAndContinueEditCmsPageActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete Configurable Product");
		$I->deleteEntity("createConfigurableProduct", "hook"); // stepKey: deleteConfigurableProduct
		$I->comment("Delete Attribute");
		$I->deleteEntity("createVisualSwatchAttribute", "hook"); // stepKey: deleteVisualSwatchAttribute
		$I->comment("Delete CMS Page");
		$I->deleteEntity("createCmsPage", "hook"); // stepKey: deleteCmsPage
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Logout from Admin");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Swatches"})
	 * @Stories({"Swatches in CMS Widget"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontSwatchAttributeDisplayedInWidgetCMSTest(AcceptanceTester $I)
	{
		$I->conditionalClick("div[data-index=search_engine_optimisation]", "input[name=identifier]", false); // stepKey: clickToExpandSeoSection
		$I->scrollTo("input[name=identifier]"); // stepKey: scrollToUrlKey
		$grabTextFromUrlKey = $I->grabValueFrom("input[name=identifier]"); // stepKey: grabTextFromUrlKey
		$I->comment("Open Storefront CMS page");
		$I->amOnPage("/$grabTextFromUrlKey"); // stepKey: gotToCreatedCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->seeElement("//div[@class='swatch-option'][@aria-label='" . $I->retrieveEntityField('swatchAttributeOption', 'option[store_labels][0][label]', 'test') . "']"); // stepKey: seeAddedWidget
	}
}
