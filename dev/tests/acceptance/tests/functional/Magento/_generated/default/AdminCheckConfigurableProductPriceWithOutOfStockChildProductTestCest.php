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
 * @Title("MC-13750: Check Price for Configurable Product when Child is Out of Stock")
 * @Description("Login as admin and check the configurable product price when one child product is out of stock<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCheckConfigurableProductPriceWithOutOfStockChildProductTest.xml<br>")
 * @TestCaseId("MC-13750")
 * @group mtf_migrated
 */
class AdminCheckConfigurableProductPriceWithOutOfStockChildProductTestCest
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
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Create Default Category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create an attribute with three options to be used in the first child product");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigProductAttributeOption3", "hook", "productAttributeOption3", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption3
		$I->comment("Add the attribute just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Get the first option of the attribute created");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->comment("Get the second option of the attribute created");
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Get the third option of the attribute created");
		$I->getEntity("getConfigAttributeOption3", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 3); // stepKey: getConfigAttributeOption3
		$I->comment("Create Configurable product");
		$I->createEntity("createConfigProduct", "hook", "BaseConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create a simple product and give it the attribute with the first option");
		$createConfigChildProduct1Fields['price'] = "10.00";
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], $createConfigChildProduct1Fields); // stepKey: createConfigChildProduct1
		$I->comment("Create a simple product and give it the attribute with the second option");
		$createConfigChildProduct2Fields['price'] = "20.00";
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], $createConfigChildProduct2Fields); // stepKey: createConfigChildProduct2
		$I->comment("Create a simple product and give it the attribute with the Third option");
		$createConfigChildProduct3Fields['price'] = "30.00";
		$I->createEntity("createConfigChildProduct3", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption3"], $createConfigChildProduct3Fields); // stepKey: createConfigChildProduct3
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductThreeOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2", "getConfigAttributeOption3"], []); // stepKey: createConfigProductOption
		$I->comment("Add the first simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->comment("Add the second simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Add the third simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild3", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct3"], []); // stepKey: createConfigProductAddChild3
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Created Data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigChildProduct3", "hook"); // stepKey: deleteConfigChildProduct3
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteAttribute
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Configurable Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckConfigurableProductPriceWithOutOfStockChildProductTest(AcceptanceTester $I)
	{
		$I->comment("Open Product in Store Front Page");
		$I->comment("Entering Action Group [openProductInStoreFront] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductInStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductInStoreFront
		$I->comment("Exiting Action Group [openProductInStoreFront] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Verify category,Configurable product and initial price");
		$I->comment("Entering Action Group [seeCategoryInFrontPage] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCatergoryInStoreFrontSeeCategoryInFrontPage
		$I->waitForPageLoad(30); // stepKey: seeCatergoryInStoreFrontSeeCategoryInFrontPageWaitForPageLoad
		$I->comment("Exiting Action Group [seeCategoryInFrontPage] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->comment("Entering Action Group [seeProductNameInStoreFront] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameSeeProductNameInStoreFront
		$I->comment("Exiting Action Group [seeProductNameInStoreFront] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeInitialPriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct1', 'price', 'test'), ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeInitialPriceInStoreFront
		$I->comment("Exiting Action Group [seeInitialPriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductSkuInStoreFront] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeProductSkuInStoreFront
		$I->comment("Exiting Action Group [seeProductSkuInStoreFront] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductStatusInStoreFront] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->see("In Stock", ".stock[title=Availability]>span"); // stepKey: seeProductStockStatusSeeProductStatusInStoreFront
		$I->comment("Exiting Action Group [seeProductStatusInStoreFront] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->comment("Verify First Child Product attribute option is displayed");
		$I->see($I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test'), "//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select"); // stepKey: seeOption1
		$I->comment("Select product Attribute option1, option2 and option3 and verify changes in the price");
		$I->comment("Entering Action Group [selectOption1] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test')); // stepKey: fillDropDownAttributeOptionSelectOption1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectOption1
		$I->comment("Exiting Action Group [selectOption1] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [seeChildProduct1PriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct1', 'price', 'test'), ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeChildProduct1PriceInStoreFront
		$I->comment("Exiting Action Group [seeChildProduct1PriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [selectOption2] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test')); // stepKey: fillDropDownAttributeOptionSelectOption2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectOption2
		$I->comment("Exiting Action Group [selectOption2] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [seeChildProduct2PriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct2', 'price', 'test'), ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeChildProduct2PriceInStoreFront
		$I->comment("Exiting Action Group [seeChildProduct2PriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [selectOption3] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption3', 'label', 'test')); // stepKey: fillDropDownAttributeOptionSelectOption3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectOption3
		$I->comment("Exiting Action Group [selectOption3] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [seeChildProduct3PriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct3', 'price', 'test'), ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeChildProduct3PriceInStoreFront
		$I->comment("Exiting Action Group [seeChildProduct3PriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Open Product Index Page and Filter First Child product");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [selectFirstRow] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1', 'id', 'test')); // stepKey: goToProductSelectFirstRow
		$I->comment("Exiting Action Group [selectFirstRow] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoad
		$I->scrollTo(".admin__field[data-index=qty] input"); // stepKey: scrollToProductQuantity
		$I->comment("Entering Action Group [selectOutOfStock] AdminSetStockStatusActionGroup");
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "Out of Stock"); // stepKey: setStockStatusSelectOutOfStock
		$I->waitForPageLoad(30); // stepKey: setStockStatusSelectOutOfStockWaitForPageLoad
		$I->comment("Exiting Action Group [selectOutOfStock] AdminSetStockStatusActionGroup");
		$I->comment("Disable the product");
		$I->comment("Entering Action Group [clickOnSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickOnSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickOnSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickOnSaveButton
		$I->comment("Exiting Action Group [clickOnSaveButton] AdminProductFormSaveActionGroup");
		$I->comment("Entering Action Group [messageYouSavedTheProductIsShown] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleMessageYouSavedTheProductIsShown
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: verifyMessageMessageYouSavedTheProductIsShown
		$I->comment("Exiting Action Group [messageYouSavedTheProductIsShown] AssertMessageInAdminPanelActionGroup");
		$I->comment("Open Product Store Front Page");
		$I->comment("Entering Action Group [openProductInStoreFront1] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductInStoreFront1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductInStoreFront1
		$I->comment("Exiting Action Group [openProductInStoreFront1] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Verify category,configurable product and updated price");
		$I->comment("Entering Action Group [seeCategoryInFrontPage1] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCatergoryInStoreFrontSeeCategoryInFrontPage1
		$I->waitForPageLoad(30); // stepKey: seeCatergoryInStoreFrontSeeCategoryInFrontPage1WaitForPageLoad
		$I->comment("Exiting Action Group [seeCategoryInFrontPage1] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->comment("Entering Action Group [seeProductNameInStoreFront1] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameSeeProductNameInStoreFront1
		$I->comment("Exiting Action Group [seeProductNameInStoreFront1] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeUpdatedProductPriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct2', 'price', 'test'), ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeUpdatedProductPriceInStoreFront
		$I->comment("Exiting Action Group [seeUpdatedProductPriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductSkuInStoreFront1] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeProductSkuInStoreFront1
		$I->comment("Exiting Action Group [seeProductSkuInStoreFront1] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductStatusInStoreFront1] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->see("In Stock", ".stock[title=Availability]>span"); // stepKey: seeProductStockStatusSeeProductStatusInStoreFront1
		$I->comment("Exiting Action Group [seeProductStatusInStoreFront1] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->comment("Verify product Attribute Option1 is not displayed");
		$I->dontSee($I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test'), "//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select"); // stepKey: dontSeeOption1
		$I->comment("Select product Attribute option2 and option3 and verify changes in the price");
		$I->comment("Entering Action Group [selectTheOption2] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test')); // stepKey: fillDropDownAttributeOptionSelectTheOption2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectTheOption2
		$I->comment("Exiting Action Group [selectTheOption2] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [seeSecondChildProductPriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct2', 'price', 'test'), ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeSecondChildProductPriceInStoreFront
		$I->comment("Exiting Action Group [seeSecondChildProductPriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [selectTheOption3] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption3', 'label', 'test')); // stepKey: fillDropDownAttributeOptionSelectTheOption3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectTheOption3
		$I->comment("Exiting Action Group [selectTheOption3] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [seeThirdProductPriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct3', 'price', 'test'), ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeThirdProductPriceInStoreFront
		$I->comment("Exiting Action Group [seeThirdProductPriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
	}
}
