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
 * @Title("MC-41948: Check related and simple products with MAP assigned to configurable product displayed correctly")
 * @Description("Check related and simple products with MAP assigned to configurable product displayed correctly<h3>Test files</h3>app/code/Magento/Msrp/Test/Mftf/Test/StorefrontConfigurableProductWithMapAndRelatedProductTest.xml<br>")
 * @TestCaseId("MC-41948")
 * @group Msrp
 */
class StorefrontConfigurableProductWithMapAndRelatedProductTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Make the configurable product have two options, that are children of the default attribute set");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleProductWithPrice50", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleProductWithPrice60", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Create simple product which will be related to configurable product");
		$I->createEntity("createRelatedProduct", "hook", "SimpleProduct2", [], []); // stepKey: createRelatedProduct
		$I->comment("Enable Minimum advertised Price");
		$I->createEntity("enableMAP", "hook", "MsrpEnableMAP", [], []); // stepKey: enableMAP
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Delete related products");
		$I->deleteEntity("createRelatedProduct", "hook"); // stepKey: deleteRelatedProduct
		$I->comment("Disable Minimum advertised Price");
		$I->createEntity("disableMAP", "hook", "MsrpDisableMAP", [], []); // stepKey: disableMAP
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"Msrp"})
	 * @Stories({"Minimum advertised price"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontConfigurableProductWithMapAndRelatedProductTest(AcceptanceTester $I)
	{
		$I->comment("Set Minimum Advertised Price to configurable products");
		$I->comment("Entering Action Group [goToFirstChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1', 'id', 'test')); // stepKey: goToProductGoToFirstChildProductEditPage
		$I->comment("Exiting Action Group [goToFirstChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [setMsrpForFirstChildProduct] AdminSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonSetMsrpForFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonSetMsrpForFirstChildProductWaitForPageLoad
		$I->waitForElement("//input[@name='product[msrp]']", 30); // stepKey: waitForMsrpSetMsrpForFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: waitForMsrpSetMsrpForFirstChildProductWaitForPageLoad
		$I->fillField("//input[@name='product[msrp]']", "55.00"); // stepKey: setMsrpForFirstChildProductSetMsrpForFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: setMsrpForFirstChildProductSetMsrpForFirstChildProductWaitForPageLoad
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonSetMsrpForFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonSetMsrpForFirstChildProductWaitForPageLoad
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSetMsrpForFirstChildProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSetMsrpForFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSetMsrpForFirstChildProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSetMsrpForFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSetMsrpForFirstChildProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSetMsrpForFirstChildProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSetMsrpForFirstChildProduct
		$I->comment("Exiting Action Group [setMsrpForFirstChildProduct] AdminSetAdvancedPricingActionGroup");
		$I->comment("Entering Action Group [goToSecondChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct2', 'id', 'test')); // stepKey: goToProductGoToSecondChildProductEditPage
		$I->comment("Exiting Action Group [goToSecondChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [setMsrpForSecondChildProduct] AdminSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonSetMsrpForSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonSetMsrpForSecondChildProductWaitForPageLoad
		$I->waitForElement("//input[@name='product[msrp]']", 30); // stepKey: waitForMsrpSetMsrpForSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: waitForMsrpSetMsrpForSecondChildProductWaitForPageLoad
		$I->fillField("//input[@name='product[msrp]']", "65.00"); // stepKey: setMsrpForFirstChildProductSetMsrpForSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: setMsrpForFirstChildProductSetMsrpForSecondChildProductWaitForPageLoad
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonSetMsrpForSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonSetMsrpForSecondChildProductWaitForPageLoad
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSetMsrpForSecondChildProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSetMsrpForSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSetMsrpForSecondChildProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSetMsrpForSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSetMsrpForSecondChildProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSetMsrpForSecondChildProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSetMsrpForSecondChildProduct
		$I->comment("Exiting Action Group [setMsrpForSecondChildProduct] AdminSetAdvancedPricingActionGroup");
		$I->comment("Add related product to configurable product");
		$I->comment("Entering Action Group [searchForConfigProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForConfigProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForConfigProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForConfigProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForConfigProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForConfigProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createConfigProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForConfigProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForConfigProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForConfigProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForConfigProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createConfigProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createConfigProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct
		$I->comment("Exiting Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [addRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProductWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createRelatedProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProductWaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProductWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Entering Action Group [clickSaveButtonConfigurableProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButtonConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonConfigurableProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButtonConfigurableProduct
		$I->comment("Exiting Action Group [clickSaveButtonConfigurableProduct] AdminProductFormSaveActionGroup");
		$I->comment("Set Minimum Advertised Price to related product");
		$I->comment("Entering Action Group [goToRelatedProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createRelatedProduct', 'id', 'test')); // stepKey: goToProductGoToRelatedProductEditPage
		$I->comment("Exiting Action Group [goToRelatedProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [setMsrpForRelatedProduct] AdminSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonSetMsrpForRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonSetMsrpForRelatedProductWaitForPageLoad
		$I->waitForElement("//input[@name='product[msrp]']", 30); // stepKey: waitForMsrpSetMsrpForRelatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForMsrpSetMsrpForRelatedProductWaitForPageLoad
		$I->fillField("//input[@name='product[msrp]']", "155.00"); // stepKey: setMsrpForFirstChildProductSetMsrpForRelatedProduct
		$I->waitForPageLoad(30); // stepKey: setMsrpForFirstChildProductSetMsrpForRelatedProductWaitForPageLoad
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonSetMsrpForRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonSetMsrpForRelatedProductWaitForPageLoad
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSetMsrpForRelatedProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSetMsrpForRelatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSetMsrpForRelatedProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSetMsrpForRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSetMsrpForRelatedProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSetMsrpForRelatedProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSetMsrpForRelatedProduct
		$I->comment("Exiting Action Group [setMsrpForRelatedProduct] AdminSetAdvancedPricingActionGroup");
		$I->comment("Entering Action Group [clickSaveButtonRelatedProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButtonRelatedProduct
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonRelatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButtonRelatedProduct
		$I->comment("Exiting Action Group [clickSaveButtonRelatedProduct] AdminProductFormSaveActionGroup");
		$I->comment("Go to store front and check msrp for products");
		$I->comment("Entering Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [checkMapForConfigurableProductOption2] StorefrontConfigurableProductCheckMapActionGroup");
		$I->comment("Check msrp for configurable product option");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('getConfigAttributeOption2', 'value', 'test')); // stepKey: selectOptionCheckMapForConfigurableProductOption2
		$I->waitForElement("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]", 30); // stepKey: waitForLoadCheckMapForConfigurableProductOption2
		$grabProductMapPriceCheckMapForConfigurableProductOption2 = $I->grabTextFrom("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]"); // stepKey: grabProductMapPriceCheckMapForConfigurableProductOption2
		$I->assertEquals("$65.00", ($grabProductMapPriceCheckMapForConfigurableProductOption2)); // stepKey: assertProductMapPriceCheckMapForConfigurableProductOption2
		$I->seeElement("//div[@class='price-box price-final_price']//a[contains(text(), 'Click for price')]"); // stepKey: checkClickForPriceLinkForProductCheckMapForConfigurableProductOption2
		$I->comment("Exiting Action Group [checkMapForConfigurableProductOption2] StorefrontConfigurableProductCheckMapActionGroup");
		$I->comment("Entering Action Group [checkMapForConfigurableProduct] StorefrontConfigurableProductCheckMapActionGroup");
		$I->comment("Check msrp for configurable product option");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('getConfigAttributeOption1', 'value', 'test')); // stepKey: selectOptionCheckMapForConfigurableProduct
		$I->waitForElement("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]", 30); // stepKey: waitForLoadCheckMapForConfigurableProduct
		$grabProductMapPriceCheckMapForConfigurableProduct = $I->grabTextFrom("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]"); // stepKey: grabProductMapPriceCheckMapForConfigurableProduct
		$I->assertEquals("$55.00", ($grabProductMapPriceCheckMapForConfigurableProduct)); // stepKey: assertProductMapPriceCheckMapForConfigurableProduct
		$I->seeElement("//div[@class='price-box price-final_price']//a[contains(text(), 'Click for price')]"); // stepKey: checkClickForPriceLinkForProductCheckMapForConfigurableProduct
		$I->comment("Exiting Action Group [checkMapForConfigurableProduct] StorefrontConfigurableProductCheckMapActionGroup");
		$I->comment("Check related product map price");
		$I->comment("Entering Action Group [checkMapForRelatedProductOption1] StorefrontAssertRelatedProductMapOnProductPageActionGroup");
		$I->waitForElementVisible(".block.related .products.wrapper.grid.products-grid.products-related", 30); // stepKey: waitForRelatedProductsListCheckMapForRelatedProductOption1
		$I->see($I->retrieveEntityField('createRelatedProduct', 'name', 'test'), ".block.related .products.wrapper.grid.products-grid.products-related"); // stepKey: seeRelatedProductCheckMapForRelatedProductOption1
		$I->seeElement("//*[@class='block related']//span[contains(@class, 'price-msrp_price')]"); // stepKey: seeFirstRelatedProductMapPriceCheckMapForRelatedProductOption1
		$grabFirstRelatedProductMapPriceCheckMapForRelatedProductOption1 = $I->grabTextFrom("//*[@class='block related']//span[contains(@class, 'price-msrp_price')]"); // stepKey: grabFirstRelatedProductMapPriceCheckMapForRelatedProductOption1
		$I->assertEquals("$155.00", ($grabFirstRelatedProductMapPriceCheckMapForRelatedProductOption1)); // stepKey: assertFirstRelatedProductMapPriceCheckMapForRelatedProductOption1
		$I->comment("Exiting Action Group [checkMapForRelatedProductOption1] StorefrontAssertRelatedProductMapOnProductPageActionGroup");
	}
}
