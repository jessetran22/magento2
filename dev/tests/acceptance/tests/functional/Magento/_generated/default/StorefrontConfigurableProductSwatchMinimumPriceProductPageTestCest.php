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
 * @Title("MC-19683: Swatch option should show the lowest price possible on product page")
 * @Description("Swatch option should show the lowest price possible on product page<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/StorefrontConfigurableProductSwatchMinimumPriceTest/StorefrontConfigurableProductSwatchMinimumPriceProductPageTest.xml<br>")
 * @TestCaseId("MC-19683")
 * @group Swatches
 */
class StorefrontConfigurableProductSwatchMinimumPriceProductPageTestCest
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
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete configurable product and all child products");
		$I->comment("Entering Action Group [deleteProductsByKeyword] DeleteProductsByKeywordActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProductsByKeyword
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProductsByKeyword
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProductsByKeywordWaitForPageLoad
		$I->fillField("input#fulltext", "testSku" . msq("_defaultProduct")); // stepKey: fillKeywordFieldDeleteProductsByKeyword
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: keywordSearchButtonDeleteProductsByKeyword
		$I->waitForPageLoad(30); // stepKey: keywordSearchButtonDeleteProductsByKeywordWaitForPageLoad
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProductsByKeyword
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProductsByKeyword
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProductsByKeyword
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductsByKeywordWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProductsByKeyword
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductsByKeywordWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteProductsByKeyword
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteProductsByKeywordWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteProductsByKeyword
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductsByKeywordWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteProductsByKeyword
		$I->comment("Exiting Action Group [deleteProductsByKeyword] DeleteProductsByKeywordActionGroup");
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategoryAttribute
		$I->comment("Delete color attribute");
		$I->comment("Entering Action Group [deleteColorAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteColorAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteColorAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteColorAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "color_attr" . msq("ProductColorAttribute")); // stepKey: setAttributeCodeDeleteColorAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteColorAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteColorAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteColorAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteColorAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteColorAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteColorAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteColorAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteColorAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteColorAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteColorAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteColorAttribute
		$I->comment("Exiting Action Group [deleteColorAttribute] DeleteProductAttributeActionGroup");
		$I->comment("Delete size attribute");
		$I->comment("Entering Action Group [deleteSizeAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteSizeAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteSizeAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteSizeAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "size_attr" . msq("ProductSizeAttribute")); // stepKey: setAttributeCodeDeleteSizeAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteSizeAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteSizeAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteSizeAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteSizeAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteSizeAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteSizeAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteSizeAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteSizeAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteSizeAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteSizeAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteSizeAttribute
		$I->comment("Exiting Action Group [deleteSizeAttribute] DeleteProductAttributeActionGroup");
		$I->comment("Logout");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Stories({"Configurable product with swatch attribute"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontConfigurableProductSwatchMinimumPriceProductPageTest(AcceptanceTester $I)
	{
		$I->comment("Create text swatch attribute with 3 options:  Black, White and Blue");
		$I->comment("Entering Action Group [addColorAttribute] AddTextSwatchToProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageAddColorAttribute
		$I->waitForPageLoad(30); // stepKey: waitForNewProductAttributePageAddColorAttribute
		$I->fillField("#attribute_label", "Color"); // stepKey: fillDefaultLabelAddColorAttribute
		$I->selectOption("#frontend_input", "Text Swatch"); // stepKey: selectInputTypeAddColorAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch1AddColorAttribute
		$I->fillField("input[name='swatchtext[value][option_0][0]']", "Black"); // stepKey: fillSwatch1AddColorAttribute
		$I->fillField("input[name='optiontext[value][option_0][0]']", "Black"); // stepKey: fillSwatch1DescriptionAddColorAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch2AddColorAttribute
		$I->fillField("input[name='swatchtext[value][option_1][0]']", "White"); // stepKey: fillSwatch2AddColorAttribute
		$I->fillField("input[name='optiontext[value][option_1][0]']", "White"); // stepKey: fillSwatch2DescriptionAddColorAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch3AddColorAttribute
		$I->fillField("input[name='swatchtext[value][option_2][0]']", "Blue"); // stepKey: fillSwatch3AddColorAttribute
		$I->fillField("input[name='optiontext[value][option_2][0]']", "Blue"); // stepKey: fillSwatch3DescriptionAddColorAttribute
		$I->click("#advanced_fieldset-wrapper"); // stepKey: expandAdvancedPropertiesAddColorAttribute
		$I->selectOption("#is_global", "1"); // stepKey: selectGlobalScopeAddColorAttribute
		$I->fillField("#attribute_code", "color_attr" . msq("ProductColorAttribute")); // stepKey: fillAttributeCodeFieldAddColorAttribute
		$I->scrollToTopOfPage(); // stepKey: scrollToTabsAddColorAttribute
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTabAddColorAttribute
		$I->waitForElementVisible("#used_in_product_listing", 30); // stepKey: waitForTabSwitchAddColorAttribute
		$I->selectOption("#used_in_product_listing", "Yes"); // stepKey: useInProductListingAddColorAttribute
		$I->selectOption("#is_filterable", "No"); // stepKey: useInLayeredNavigationAddColorAttribute
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAddColorAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveAddColorAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [addColorAttribute] AddTextSwatchToProductActionGroup");
		$I->comment("Create text swatch attribute with 3 options:  Small, Medium and Large");
		$I->comment("Entering Action Group [addSizeAttribute] AddTextSwatchToProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageAddSizeAttribute
		$I->waitForPageLoad(30); // stepKey: waitForNewProductAttributePageAddSizeAttribute
		$I->fillField("#attribute_label", "Size"); // stepKey: fillDefaultLabelAddSizeAttribute
		$I->selectOption("#frontend_input", "Text Swatch"); // stepKey: selectInputTypeAddSizeAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch1AddSizeAttribute
		$I->fillField("input[name='swatchtext[value][option_0][0]']", "Small"); // stepKey: fillSwatch1AddSizeAttribute
		$I->fillField("input[name='optiontext[value][option_0][0]']", "Small"); // stepKey: fillSwatch1DescriptionAddSizeAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch2AddSizeAttribute
		$I->fillField("input[name='swatchtext[value][option_1][0]']", "Medium"); // stepKey: fillSwatch2AddSizeAttribute
		$I->fillField("input[name='optiontext[value][option_1][0]']", "Medium"); // stepKey: fillSwatch2DescriptionAddSizeAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch3AddSizeAttribute
		$I->fillField("input[name='swatchtext[value][option_2][0]']", "Large"); // stepKey: fillSwatch3AddSizeAttribute
		$I->fillField("input[name='optiontext[value][option_2][0]']", "Large"); // stepKey: fillSwatch3DescriptionAddSizeAttribute
		$I->click("#advanced_fieldset-wrapper"); // stepKey: expandAdvancedPropertiesAddSizeAttribute
		$I->selectOption("#is_global", "1"); // stepKey: selectGlobalScopeAddSizeAttribute
		$I->fillField("#attribute_code", "size_attr" . msq("ProductSizeAttribute")); // stepKey: fillAttributeCodeFieldAddSizeAttribute
		$I->scrollToTopOfPage(); // stepKey: scrollToTabsAddSizeAttribute
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTabAddSizeAttribute
		$I->waitForElementVisible("#used_in_product_listing", 30); // stepKey: waitForTabSwitchAddSizeAttribute
		$I->selectOption("#used_in_product_listing", "No"); // stepKey: useInProductListingAddSizeAttribute
		$I->selectOption("#is_filterable", "No"); // stepKey: useInLayeredNavigationAddSizeAttribute
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAddSizeAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveAddSizeAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [addSizeAttribute] AddTextSwatchToProductActionGroup");
		$I->comment("Create configurable product with two attributes: Color and Size");
		$I->comment("Entering Action Group [createProduct] CreateConfigurableProductWithTwoAttributesActionGroup");
		$I->comment("fill in basic configurable product values");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: amOnProductGridPageCreateProduct
		$I->waitForPageLoad(30); // stepKey: wait1CreateProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickOnAddProductToggleCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAddProductToggleCreateProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickOnAddConfigurableProductCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAddConfigurableProductCreateProductWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillNameCreateProduct
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKUCreateProduct
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPriceCreateProduct
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantityCreateProduct
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategoryCreateProduct
		$I->waitForPageLoad(30); // stepKey: fillCategoryCreateProductWaitForPageLoad
		$I->selectOption("//select[@name='product[visibility]']", "4"); // stepKey: fillVisibilityCreateProduct
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionCreateProduct
		$I->waitForPageLoad(30); // stepKey: openSeoSectionCreateProductWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKeyCreateProduct
		$I->comment("create configurations for colors the product is available in");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickOnCreateConfigurationsCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCreateConfigurationsCreateProductWaitForPageLoad
		$I->click("//div[contains(text(), 'color_attr" . msq("ProductColorAttribute") . "')]/ancestor::tr//input[@data-action='select-row']"); // stepKey: selectAttribute1CreateProduct
		$I->click("//div[contains(text(), 'size_attr" . msq("ProductSizeAttribute") . "')]/ancestor::tr//input[@data-action='select-row']"); // stepKey: selectAttribute2CreateProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateProductWaitForPageLoad
		$I->click("//div[@data-attribute-title='Color']//button[contains(@class, 'action-select-all')]"); // stepKey: selectAllOptionsOfAttribute1CreateProduct
		$I->click("//div[@data-attribute-title='Size']//button[contains(@class, 'action-select-all')]"); // stepKey: selectAllOptionsOfAttribute2CreateProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateProductWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateProductWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "1"); // stepKey: enterAttributeQuantityCreateProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateProductWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateProductWaitForPageLoad
		$I->comment("Exiting Action Group [createProduct] CreateConfigurableProductWithTwoAttributesActionGroup");
		$I->comment("Set Black-Small product price to 10");
		$I->comment("Entering Action Group [changeBlackSmallPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Color: Black, Size: Small')]/ancestor::tr/td[@data-index='price_container']//input", "10"); // stepKey: fillPriceForConfigurableProductAttributeOptionChangeBlackSmallPrice
		$I->comment("Exiting Action Group [changeBlackSmallPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->comment("Set Black-Medium product price to 11");
		$I->comment("Entering Action Group [changeBlackMediumPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Color: Black, Size: Medium')]/ancestor::tr/td[@data-index='price_container']//input", "11"); // stepKey: fillPriceForConfigurableProductAttributeOptionChangeBlackMediumPrice
		$I->comment("Exiting Action Group [changeBlackMediumPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->comment("Set Black-Large product price to 12");
		$I->comment("Entering Action Group [changeBlackLargePrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Color: Black, Size: Large')]/ancestor::tr/td[@data-index='price_container']//input", "12"); // stepKey: fillPriceForConfigurableProductAttributeOptionChangeBlackLargePrice
		$I->comment("Exiting Action Group [changeBlackLargePrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->comment("Set White-Small product price to 14");
		$I->comment("Entering Action Group [changeWhiteSmallPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Color: White, Size: Small')]/ancestor::tr/td[@data-index='price_container']//input", "14"); // stepKey: fillPriceForConfigurableProductAttributeOptionChangeWhiteSmallPrice
		$I->comment("Exiting Action Group [changeWhiteSmallPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->comment("Set White-Medium product price to 13");
		$I->comment("Entering Action Group [changeWhiteMediumPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Color: White, Size: Medium')]/ancestor::tr/td[@data-index='price_container']//input", "13"); // stepKey: fillPriceForConfigurableProductAttributeOptionChangeWhiteMediumPrice
		$I->comment("Exiting Action Group [changeWhiteMediumPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->comment("Set White-Large product price to 15");
		$I->comment("Entering Action Group [changeWhiteLargePrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Color: White, Size: Large')]/ancestor::tr/td[@data-index='price_container']//input", "15"); // stepKey: fillPriceForConfigurableProductAttributeOptionChangeWhiteLargePrice
		$I->comment("Exiting Action Group [changeWhiteLargePrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->comment("Set Blue-Small product price to 18");
		$I->comment("Entering Action Group [changeBlueSmallPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Color: Blue, Size: Small')]/ancestor::tr/td[@data-index='price_container']//input", "18"); // stepKey: fillPriceForConfigurableProductAttributeOptionChangeBlueSmallPrice
		$I->comment("Exiting Action Group [changeBlueSmallPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->comment("Set Blue-Medium product price to 17");
		$I->comment("Entering Action Group [changeBlueMediumPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Color: Blue, Size: Medium')]/ancestor::tr/td[@data-index='price_container']//input", "17"); // stepKey: fillPriceForConfigurableProductAttributeOptionChangeBlueMediumPrice
		$I->comment("Exiting Action Group [changeBlueMediumPrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->comment("Set Blue-Large product price to 16");
		$I->comment("Entering Action Group [changeBlueLargePrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->fillField("//*[.='Attributes']/ancestor::tr//span[contains(text(), 'Color: Blue, Size: Large')]/ancestor::tr/td[@data-index='price_container']//input", "16"); // stepKey: fillPriceForConfigurableProductAttributeOptionChangeBlueLargePrice
		$I->comment("Exiting Action Group [changeBlueLargePrice] ChangeConfigurableProductChildProductPriceActionGroup");
		$I->comment("Save configurable product");
		$I->comment("Entering Action Group [saveProduct] SaveConfigurableProductActionGroup");
		$I->click("#save-button"); // stepKey: clickOnSaveButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonSaveProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupSaveProductWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageSaveProduct
		$I->seeInTitle("testProductName" . msq("_defaultProduct")); // stepKey: seeProductNameInTitleSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveConfigurableProductActionGroup");
		$I->comment("Go to product page");
		$I->amOnPage("/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: amOnConfigurableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForConfigurableProductPage
		$I->comment("Verify that the minimum price is 10");
		$I->comment("Entering Action Group [assertProductPrice] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see("10.00", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceAssertProductPrice
		$I->comment("Exiting Action Group [assertProductPrice] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Verify that Black option's minimum price is 16");
		$I->comment("Entering Action Group [assertMinimumPriceForBlackOption] StorefrontAssertSwatchOptionPriceActionGroup");
		$I->click("div.swatch-option[data-option-label='Black']"); // stepKey: clickOnOptionAssertMinimumPriceForBlackOption
		$I->see("10.00", "div.price-box.price-final_price"); // stepKey: seeOptionPriceAssertMinimumPriceForBlackOption
		$I->comment("Exiting Action Group [assertMinimumPriceForBlackOption] StorefrontAssertSwatchOptionPriceActionGroup");
		$I->comment("Verify that White option's minimum price is 16");
		$I->comment("Entering Action Group [assertMinimumPriceForWhiteOption] StorefrontAssertSwatchOptionPriceActionGroup");
		$I->click("div.swatch-option[data-option-label='White']"); // stepKey: clickOnOptionAssertMinimumPriceForWhiteOption
		$I->see("13.00", "div.price-box.price-final_price"); // stepKey: seeOptionPriceAssertMinimumPriceForWhiteOption
		$I->comment("Exiting Action Group [assertMinimumPriceForWhiteOption] StorefrontAssertSwatchOptionPriceActionGroup");
		$I->comment("Verify that Blue option's minimum price is 16");
		$I->comment("Entering Action Group [assertMinimumPriceForBlueOption] StorefrontAssertSwatchOptionPriceActionGroup");
		$I->click("div.swatch-option[data-option-label='Blue']"); // stepKey: clickOnOptionAssertMinimumPriceForBlueOption
		$I->see("16.00", "div.price-box.price-final_price"); // stepKey: seeOptionPriceAssertMinimumPriceForBlueOption
		$I->comment("Exiting Action Group [assertMinimumPriceForBlueOption] StorefrontAssertSwatchOptionPriceActionGroup");
	}
}
