<?php
namespace Magento\AcceptanceTest\_SearchEngineElasticsearchSuite\Backend;

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
 * @group e2e
 * @group SearchEngineElasticsearch
 * @Title("MAGETWO-87435: You should be able to pass End to End B2C Guest User scenario")
 * @Description("User browses catalog, searches for product, adds product to cart, adds product to wishlist, compares products, uses coupon code and checks out.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/EndToEndB2CGuestUserTest/EndToEndB2CGuestUserTest.xml<br>app/code/Magento/Checkout/Test/Mftf/Test/EndToEndB2CGuestUserTest/EndToEndB2CGuestUserTest.xml<br>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/EndToEndB2CGuestUserTest/EndToEndB2CGuestUserTest.xml<br>app/code/Magento/CatalogSearch/Test/Mftf/Test/EndToEndB2CGuestUserTest/EndToEndB2CGuestUserTest.xml<br>app/code/Magento/SalesRule/Test/Mftf/Test/EndToEndB2CGuestUserTest/EndToEndB2CGuestUserTest.xml<br>dev/tests/acceptance/tests/functional/Magento/ConfigurableProductCatalogSearch/Test/EndToEndB2CGuestUserTest/EndToEndB2CGuestUserTest.xml<br>")
 * @TestCaseId("MAGETWO-87435")
 */
class EndToEndB2CGuestUserTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->resetCookie("PHPSESSID"); // stepKey: resetCookieForCart
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct1", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct1
		$I->createEntity("createSimpleProduct1Image", "hook", "ApiProductAttributeMediaGalleryEntryTestImage", ["createSimpleProduct1"], []); // stepKey: createSimpleProduct1Image
		$I->createEntity("createSimpleProduct1Image1", "hook", "ApiProductAttributeMediaGalleryEntryMagentoLogo", ["createSimpleProduct1"], []); // stepKey: createSimpleProduct1Image1
		$I->updateEntity("createSimpleProduct1", "hook", "ApiSimpleProductUpdateDescription",[]); // stepKey: updateSimpleProduct1
		$I->createEntity("createSimpleProduct2", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct2
		$I->createEntity("createSimpleProduct2Image", "hook", "ApiProductAttributeMediaGalleryEntryTestImage", ["createSimpleProduct2"], []); // stepKey: createSimpleProduct2Image
		$I->updateEntity("createSimpleProduct2", "hook", "ApiSimpleProductUpdateDescription",[]); // stepKey: updateSimpleProduct2
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct1Image", "hook", "ApiProductAttributeMediaGalleryEntryTestImage", ["createConfigChildProduct1"], []); // stepKey: createConfigChildProduct1Image
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigChildProduct2Image", "hook", "ApiProductAttributeMediaGalleryEntryMagentoLogo", ["createConfigChildProduct2"], []); // stepKey: createConfigChildProduct2Image
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->createEntity("createConfigProductImage", "hook", "ApiProductAttributeMediaGalleryEntryTestImage", ["createConfigProduct"], []); // stepKey: createConfigProductImage
		$I->updateEntity("createConfigProduct", "hook", "ApiSimpleProductUpdateDescription",[]); // stepKey: updateConfigProduct
		$I->createEntity("createSalesRule", "hook", "ApiSalesRule", [], []); // stepKey: createSalesRule
		$I->createEntity("createSalesRuleCoupon", "hook", "ApiSalesRuleCoupon", ["createSalesRule"], []); // stepKey: createSalesRuleCoupon
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("@TODO: Uncomment once MQE-679 is fixed");
		$I->comment("<deleteData createDataKey=\"createSimpleProduct1Image\" stepKey=\"deleteSimpleProduct1Image\"/>");
		$I->comment("@TODO: Uncomment once MQE-679 is fixed");
		$I->comment("<deleteData createDataKey=\"createSimpleProduct1Image1\" stepKey=\"deleteSimpleProduct1Image1\"/>");
		$I->deleteEntity("createSimpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->comment("@TODO: Uncomment once MQE-679 is fixed");
		$I->comment("<deleteData createDataKey=\"createSimpleProduct2Image\" stepKey=\"deleteSimpleProduct2Image\"/>");
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->deleteEntity("createSalesRule", "hook"); // stepKey: deleteSalesRule
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
	 * @Stories({"B2C guest user - MAGETWO-75411"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function EndToEndB2CGuestUserTest(AcceptanceTester $I)
	{
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Step 1: User browses catalog");
		$I->comment("Start of browsing catalog");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->waitForElementVisible("header>.panel .greet.welcome", 30); // stepKey: homeWaitForWelcomeMessage
		$I->see("Default welcome msg!", "header>.panel .greet.welcome"); // stepKey: homeCheckWelcome
		$I->comment("Open Category");
		$I->comment("Open category");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: browseClickCategory
		$I->waitForPageLoad(30); // stepKey: browseClickCategoryWaitForPageLoad
		$I->comment("Entering Action Group [browseAssertCategory] StorefrontCheckCategoryActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlBrowseAssertCategory
		$I->seeInTitle($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: assertCategoryNameInTitleBrowseAssertCategory
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameBrowseAssertCategory
		$I->see("3", "#toolbar-amount span"); // stepKey: assertProductCountBrowseAssertCategory
		$I->comment("Exiting Action Group [browseAssertCategory] StorefrontCheckCategoryActionGroup");
		$I->comment("Check simple product 1 in category");
		$I->comment("Check simple product 1 in category");
		$I->comment("Entering Action Group [browseAssertCategoryProduct1] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]", 30); // stepKey: waitForProductBrowseAssertCategoryProduct1
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: assertProductNameBrowseAssertCategoryProduct1
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceBrowseAssertCategoryProduct1
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductBrowseAssertCategoryProduct1
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartBrowseAssertCategoryProduct1
		$I->comment("Exiting Action Group [browseAssertCategoryProduct1] StorefrontCheckCategorySimpleProductActionGroup");
		$I->comment("@TODO: Move Image check to action group after MQE-697 is fixed");
		$browseGrabSimpleProduct1ImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: browseGrabSimpleProduct1ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $browseGrabSimpleProduct1ImageSrc); // stepKey: browseAssertSimpleProduct1ImageNotDefault
		$I->comment("Check simple product 2 in category");
		$I->comment("Check simple product 2 in category");
		$I->comment("Entering Action Group [browseAssertCategoryProduct2] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]", 30); // stepKey: waitForProductBrowseAssertCategoryProduct2
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: assertProductNameBrowseAssertCategoryProduct2
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct2', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceBrowseAssertCategoryProduct2
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductBrowseAssertCategoryProduct2
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartBrowseAssertCategoryProduct2
		$I->comment("Exiting Action Group [browseAssertCategoryProduct2] StorefrontCheckCategorySimpleProductActionGroup");
		$I->comment("@TODO: Move Image check to action group after MQE-697 is fixed");
		$browseGrabSimpleProduct2ImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: browseGrabSimpleProduct2ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $browseGrabSimpleProduct2ImageSrc); // stepKey: browseAssertSimpleProduct2ImageNotDefault
		$I->comment("Verify Configurable Product in category");
		$I->comment("Entering Action Group [browseAssertCategoryConfigProduct] StorefrontCheckCategoryConfigurableProductActionGroup");
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: assertProductNameBrowseAssertCategoryConfigProduct
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceBrowseAssertCategoryConfigProduct
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductBrowseAssertCategoryConfigProduct
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartBrowseAssertCategoryConfigProduct
		$I->comment("Exiting Action Group [browseAssertCategoryConfigProduct] StorefrontCheckCategoryConfigurableProductActionGroup");
		$browseGrabConfigProductImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: browseGrabConfigProductImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $browseGrabConfigProductImageSrc); // stepKey: browseAssertConfigProductImageNotDefault
		$I->comment("View simple product 1");
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: browseClickCategorySimpleProduct1View
		$I->comment("View Simple Product 1");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSimpleProduct1Viewloaded
		$I->comment("Entering Action Group [browseAssertProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlBrowseAssertProduct1Page
		$I->seeInTitle($I->retrieveEntityField('createSimpleProduct1', 'name', 'test')); // stepKey: AssertProductNameInTitleBrowseAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), ".base"); // stepKey: assertProductNameBrowseAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuBrowseAssertProduct1Page
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceBrowseAssertProduct1Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockBrowseAssertProduct1Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartBrowseAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionBrowseAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionBrowseAssertProduct1Page
		$I->comment("Exiting Action Group [browseAssertProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$I->comment("@TODO: Move Image check to action group after MQE-697 is fixed");
		$browseGrabSimpleProduct1PageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: browseGrabSimpleProduct1PageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $browseGrabSimpleProduct1PageImageSrc); // stepKey: browseAssertSimpleProduct1PageImageNotDefault
		$I->comment("View Simple Product 2");
		$I->comment("View simple product 2");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: clickCategory1
		$I->waitForPageLoad(30); // stepKey: clickCategory1WaitForPageLoad
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: browseClickCategorySimpleProduct2View
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSimpleProduct2ViewLoaded
		$I->comment("Entering Action Group [browseAssertProduct2Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlBrowseAssertProduct2Page
		$I->seeInTitle($I->retrieveEntityField('createSimpleProduct2', 'name', 'test')); // stepKey: AssertProductNameInTitleBrowseAssertProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), ".base"); // stepKey: assertProductNameBrowseAssertProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuBrowseAssertProduct2Page
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct2', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceBrowseAssertProduct2Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockBrowseAssertProduct2Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartBrowseAssertProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionBrowseAssertProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionBrowseAssertProduct2Page
		$I->comment("Exiting Action Group [browseAssertProduct2Page] StorefrontCheckSimpleProductActionGroup");
		$I->comment("@TODO: Move Image check to action group after MQE-697 is fixed");
		$browseGrabSimpleProduct2PageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: browseGrabSimpleProduct2PageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $browseGrabSimpleProduct2PageImageSrc); // stepKey: browseAssertSimpleProduct2PageImageNotDefault
		$I->comment("View Configurable Product");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: clickCategory2
		$I->waitForPageLoad(30); // stepKey: clickCategory2WaitForPageLoad
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: browseClickCategoryConfigProductView
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForConfigurableProductViewloaded
		$I->comment("Entering Action Group [browseAssertConfigProductPage] StorefrontCheckConfigurableProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlBrowseAssertConfigProductPage
		$I->seeInTitle($I->retrieveEntityField('createConfigProduct', 'name', 'test')); // stepKey: AssertProductNameInTitleBrowseAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameBrowseAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuBrowseAssertConfigProductPage
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceBrowseAssertConfigProductPage
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockBrowseAssertConfigProductPage
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartBrowseAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionBrowseAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionBrowseAssertConfigProductPage
		$I->comment("Exiting Action Group [browseAssertConfigProductPage] StorefrontCheckConfigurableProductActionGroup");
		$browseGrabConfigProductPageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: browseGrabConfigProductPageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $browseGrabConfigProductPageImageSrc); // stepKey: browseAssertConfigProductPageImageNotDefault
		$I->comment("End of browsing catalog");
		$I->comment("Start of searching products");
		$I->comment("Advanced search");
		$I->comment("Entering Action Group [searchOpenAdvancedSearchForm] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkSearchOpenAdvancedSearchForm
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlSearchOpenAdvancedSearchForm
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1SearchOpenAdvancedSearchForm
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2SearchOpenAdvancedSearchForm
		$I->comment("Exiting Action Group [searchOpenAdvancedSearchForm] StorefrontOpenAdvancedSearchActionGroup");
		$I->fillField("#name", $I->retrieveEntityField('createSimpleProduct1', 'name', 'test')); // stepKey: searchAdvancedFillProductName
		$I->fillField("#sku", $I->retrieveEntityField('createSimpleProduct1', 'sku', 'test')); // stepKey: searchAdvancedFillSKU
		$I->fillField("#price", $I->retrieveEntityField('createSimpleProduct1', 'price', 'test')); // stepKey: searchAdvancedFillPriceFrom
		$I->fillField("#price_to", $I->retrieveEntityField('createSimpleProduct1', 'price', 'test')); // stepKey: searchAdvancedFillPriceTo
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: searchClickAdvancedSearchSubmitButton
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSearchProductsloaded
		$I->comment("Entering Action Group [searchCheckAdvancedSearchResult] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlSearchCheckAdvancedSearchResult
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleSearchCheckAdvancedSearchResult
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameSearchCheckAdvancedSearchResult
		$I->comment("Exiting Action Group [searchCheckAdvancedSearchResult] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->see("4", "#toolbar-amount span"); // stepKey: searchAdvancedAssertProductCount
		$I->comment("Entering Action Group [searchAssertSimpleProduct1] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]", 30); // stepKey: waitForProductSearchAssertSimpleProduct1
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: assertProductNameSearchAssertSimpleProduct1
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceSearchAssertSimpleProduct1
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductSearchAssertSimpleProduct1
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartSearchAssertSimpleProduct1
		$I->comment("Exiting Action Group [searchAssertSimpleProduct1] StorefrontCheckCategorySimpleProductActionGroup");
		$searchAdvancedGrabSimpleProduct1ImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: searchAdvancedGrabSimpleProduct1ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $searchAdvancedGrabSimpleProduct1ImageSrc); // stepKey: searchAdvancedAssertSimpleProduct1ImageNotDefault
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: searchClickSimpleProduct1View
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSearchSimpleProduct1Viewloaded
		$I->comment("Entering Action Group [searchAssertSimpleProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlSearchAssertSimpleProduct1Page
		$I->seeInTitle($I->retrieveEntityField('createSimpleProduct1', 'name', 'test')); // stepKey: AssertProductNameInTitleSearchAssertSimpleProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), ".base"); // stepKey: assertProductNameSearchAssertSimpleProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuSearchAssertSimpleProduct1Page
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceSearchAssertSimpleProduct1Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockSearchAssertSimpleProduct1Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartSearchAssertSimpleProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionSearchAssertSimpleProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionSearchAssertSimpleProduct1Page
		$I->comment("Exiting Action Group [searchAssertSimpleProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$searchAdvancedGrabSimpleProduct1PageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: searchAdvancedGrabSimpleProduct1PageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $searchAdvancedGrabSimpleProduct1PageImageSrc); // stepKey: searchAdvancedAssertSimpleProduct1PageImageNotDefault
		$I->comment("Quick search");
		$I->comment("Entering Action Group [searchQuickSearchCommonPart] StorefrontCheckQuickSearchActionGroup");
		$I->submitForm("#search_mini_form", ['q' => "Api Simple Product"]); // stepKey: fillQuickSearchSearchQuickSearchCommonPart
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchQuickSearchCommonPart
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchQuickSearchCommonPart
		$I->seeInTitle("Search results for: 'Api Simple Product'"); // stepKey: assertQuickSearchTitleSearchQuickSearchCommonPart
		$I->see("Search results for: 'Api Simple Product'", ".page-title span"); // stepKey: assertQuickSearchNameSearchQuickSearchCommonPart
		$I->comment("Exiting Action Group [searchQuickSearchCommonPart] StorefrontCheckQuickSearchActionGroup");
		$I->comment("Entering Action Group [searchSelectFilterCategoryCommonPart] StorefrontSelectSearchFilterCategoryActionGroup");
		$I->click("//main//div[@class='filter-options']//div[contains(text(), 'Category')]"); // stepKey: clickCategoryFilterTitleSearchSelectFilterCategoryCommonPart
		$I->scrollTo("//main//div[@class='filter-options']//li[@class='item']//a[contains(text(), '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: scrollToClickCategoryFilterSearchSelectFilterCategoryCommonPart
		$I->click("//main//div[@class='filter-options']//li[@class='item']//a[contains(text(), '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: clickCategoryFilterSearchSelectFilterCategoryCommonPart
		$I->comment("Exiting Action Group [searchSelectFilterCategoryCommonPart] StorefrontSelectSearchFilterCategoryActionGroup");
		$I->see("3", "#toolbar-amount span"); // stepKey: searchAssertFilterCategoryProductCountCommonPart
		$I->comment("Search simple product 1");
		$I->comment("Entering Action Group [searchAssertFilterCategorySimpleProduct1] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]", 30); // stepKey: waitForProductSearchAssertFilterCategorySimpleProduct1
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: assertProductNameSearchAssertFilterCategorySimpleProduct1
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceSearchAssertFilterCategorySimpleProduct1
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductSearchAssertFilterCategorySimpleProduct1
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartSearchAssertFilterCategorySimpleProduct1
		$I->comment("Exiting Action Group [searchAssertFilterCategorySimpleProduct1] StorefrontCheckCategorySimpleProductActionGroup");
		$searchGrabSimpleProduct1ImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: searchGrabSimpleProduct1ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $searchGrabSimpleProduct1ImageSrc); // stepKey: searchAssertSimpleProduct1ImageNotDefault
		$I->comment("Entering Action Group [searchAssertFilterCategorySimpleProduct2] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]", 30); // stepKey: waitForProductSearchAssertFilterCategorySimpleProduct2
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: assertProductNameSearchAssertFilterCategorySimpleProduct2
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct2', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceSearchAssertFilterCategorySimpleProduct2
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductSearchAssertFilterCategorySimpleProduct2
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartSearchAssertFilterCategorySimpleProduct2
		$I->comment("Exiting Action Group [searchAssertFilterCategorySimpleProduct2] StorefrontCheckCategorySimpleProductActionGroup");
		$searchGrabSimpleProduct2ImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: searchGrabSimpleProduct2ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $searchGrabSimpleProduct2ImageSrc); // stepKey: searchAssertSimpleProduct2ImageNotDefault
		$I->comment("Search configurable product");
		$I->comment("Entering Action Group [searchAssertFilterCategoryConfigProduct] StorefrontCheckCategoryConfigurableProductActionGroup");
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: assertProductNameSearchAssertFilterCategoryConfigProduct
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceSearchAssertFilterCategoryConfigProduct
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductSearchAssertFilterCategoryConfigProduct
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartSearchAssertFilterCategoryConfigProduct
		$I->comment("Exiting Action Group [searchAssertFilterCategoryConfigProduct] StorefrontCheckCategoryConfigurableProductActionGroup");
		$searchGrabConfigProductImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: searchGrabConfigProductImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $searchGrabConfigProductImageSrc); // stepKey: searchAssertConfigProductImageNotDefault
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: searchClickConfigProductView
		$I->comment("Entering Action Group [searchAssertConfigProductPage] StorefrontCheckConfigurableProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlSearchAssertConfigProductPage
		$I->seeInTitle($I->retrieveEntityField('createConfigProduct', 'name', 'test')); // stepKey: AssertProductNameInTitleSearchAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameSearchAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuSearchAssertConfigProductPage
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceSearchAssertConfigProductPage
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockSearchAssertConfigProductPage
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartSearchAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionSearchAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionSearchAssertConfigProductPage
		$I->comment("Exiting Action Group [searchAssertConfigProductPage] StorefrontCheckConfigurableProductActionGroup");
		$searchGrabConfigProductPageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: searchGrabConfigProductPageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $searchGrabConfigProductPageImageSrc); // stepKey: searchAssertConfigProductPageImageNotDefault
		$I->comment("Quick Search with non-existent product name");
		$I->comment("Entering Action Group [searchFillQuickSearchNonExistent] StorefrontCheckQuickSearchActionGroup");
		$I->submitForm("#search_mini_form", ['q' => "NonexistentProductName"]); // stepKey: fillQuickSearchSearchFillQuickSearchNonExistent
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchFillQuickSearchNonExistent
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchFillQuickSearchNonExistent
		$I->seeInTitle("Search results for: 'NonexistentProductName'"); // stepKey: assertQuickSearchTitleSearchFillQuickSearchNonExistent
		$I->see("Search results for: 'NonexistentProductName'", ".page-title span"); // stepKey: assertQuickSearchNameSearchFillQuickSearchNonExistent
		$I->comment("Exiting Action Group [searchFillQuickSearchNonExistent] StorefrontCheckQuickSearchActionGroup");
		$I->see("Your search returned no results.", "div.message div"); // stepKey: searchAssertQuickSearchMessageNonExistent
		$I->comment("End of searching products");
		$I->comment("Start of adding products to cart");
		$I->comment("Add Simple Product 1 to cart");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: cartClickCategory
		$I->waitForPageLoad(30); // stepKey: cartClickCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartCategoryloaded
		$I->comment("Entering Action Group [cartAssertCategory] StorefrontCheckCategoryActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertCategory
		$I->seeInTitle($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: assertCategoryNameInTitleCartAssertCategory
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameCartAssertCategory
		$I->see("3", "#toolbar-amount span"); // stepKey: assertProductCountCartAssertCategory
		$I->comment("Exiting Action Group [cartAssertCategory] StorefrontCheckCategoryActionGroup");
		$I->comment("Entering Action Group [cartAssertSimpleProduct1] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]", 30); // stepKey: waitForProductCartAssertSimpleProduct1
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: assertProductNameCartAssertSimpleProduct1
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceCartAssertSimpleProduct1
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCartAssertSimpleProduct1
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartCartAssertSimpleProduct1
		$I->comment("Exiting Action Group [cartAssertSimpleProduct1] StorefrontCheckCategorySimpleProductActionGroup");
		$cartGrabSimpleProduct1ImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: cartGrabSimpleProduct1ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $cartGrabSimpleProduct1ImageSrc); // stepKey: cartAssertSimpleProduct1ImageNotDefault
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: cartClickSimpleProduct1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartSimpleProduct1loaded
		$I->comment("Entering Action Group [cartAssertProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertProduct1Page
		$I->seeInTitle($I->retrieveEntityField('createSimpleProduct1', 'name', 'test')); // stepKey: AssertProductNameInTitleCartAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), ".base"); // stepKey: assertProductNameCartAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuCartAssertProduct1Page
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceCartAssertProduct1Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCartAssertProduct1Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartCartAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionCartAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionCartAssertProduct1Page
		$I->comment("Exiting Action Group [cartAssertProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$cartGrabSimpleProduct1PageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: cartGrabSimpleProduct1PageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $cartGrabSimpleProduct1PageImageSrc); // stepKey: cartAssertSimpleProduct1PageImageNotDefault
		$I->comment("Entering Action Group [cartAddProduct1ToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartCartAddProduct1ToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddProduct1ToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddProduct1ToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageCartAddProduct1ToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageCartAddProduct1ToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddProduct1ToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddProduct1ToCart
		$I->comment("Exiting Action Group [cartAddProduct1ToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Add Simple Product 2 to cart");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: cartClickCategory1
		$I->waitForPageLoad(30); // stepKey: cartClickCategory1WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartCategory1loaded
		$I->comment("Entering Action Group [cartAssertCategory1ForSimpleProduct2] StorefrontCheckCategoryActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertCategory1ForSimpleProduct2
		$I->seeInTitle($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: assertCategoryNameInTitleCartAssertCategory1ForSimpleProduct2
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameCartAssertCategory1ForSimpleProduct2
		$I->see("3", "#toolbar-amount span"); // stepKey: assertProductCountCartAssertCategory1ForSimpleProduct2
		$I->comment("Exiting Action Group [cartAssertCategory1ForSimpleProduct2] StorefrontCheckCategoryActionGroup");
		$I->comment("Entering Action Group [cartAssertSimpleProduct2] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]", 30); // stepKey: waitForProductCartAssertSimpleProduct2
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: assertProductNameCartAssertSimpleProduct2
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct2', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceCartAssertSimpleProduct2
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCartAssertSimpleProduct2
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartCartAssertSimpleProduct2
		$I->comment("Exiting Action Group [cartAssertSimpleProduct2] StorefrontCheckCategorySimpleProductActionGroup");
		$cartGrabSimpleProduct2ImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: cartGrabSimpleProduct2ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $cartGrabSimpleProduct2ImageSrc); // stepKey: cartAssertSimpleProduct2ImageNotDefault
		$I->comment("Entering Action Group [cartAddProduct2ToCart] StorefrontAddCategoryProductToCartActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCartAddProduct2ToCart
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartCartAddProduct2ToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddProduct2ToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: assertSuccessMessageCartAddProduct2ToCart
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddProduct2ToCart
		$I->waitForText("2", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddProduct2ToCart
		$I->comment("Exiting Action Group [cartAddProduct2ToCart] StorefrontAddCategoryProductToCartActionGroup");
		$I->comment("Add Configurable Product to cart");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: cartClickCategory2
		$I->waitForPageLoad(30); // stepKey: cartClickCategory2WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartCategory2loaded
		$I->comment("Entering Action Group [cartAssertCategory1ForConfigurableProduct] StorefrontCheckCategoryActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertCategory1ForConfigurableProduct
		$I->seeInTitle($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: assertCategoryNameInTitleCartAssertCategory1ForConfigurableProduct
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameCartAssertCategory1ForConfigurableProduct
		$I->see("3", "#toolbar-amount span"); // stepKey: assertProductCountCartAssertCategory1ForConfigurableProduct
		$I->comment("Exiting Action Group [cartAssertCategory1ForConfigurableProduct] StorefrontCheckCategoryActionGroup");
		$I->comment("Entering Action Group [cartAssertConfigProduct] StorefrontCheckCategoryConfigurableProductActionGroup");
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: assertProductNameCartAssertConfigProduct
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceCartAssertConfigProduct
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCartAssertConfigProduct
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartCartAssertConfigProduct
		$I->comment("Exiting Action Group [cartAssertConfigProduct] StorefrontCheckCategoryConfigurableProductActionGroup");
		$cartGrabConfigProductImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: cartGrabConfigProductImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $cartGrabConfigProductImageSrc); // stepKey: cartAssertConfigProductImageNotDefault
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: cartClickCategoryConfigProductAddToCart
		$I->waitForElement("//main//div[contains(@class, 'messages')]//div[contains(@class, 'message')]/div[contains(text(), 'You need to choose options for your item.')]", 30); // stepKey: cartWaitForConfigProductPageLoad
		$I->comment("Entering Action Group [cartAssertConfigProductPage] StorefrontCheckConfigurableProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertConfigProductPage
		$I->seeInTitle($I->retrieveEntityField('createConfigProduct', 'name', 'test')); // stepKey: AssertProductNameInTitleCartAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameCartAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuCartAssertConfigProductPage
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceCartAssertConfigProductPage
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCartAssertConfigProductPage
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartCartAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionCartAssertConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionCartAssertConfigProductPage
		$I->comment("Exiting Action Group [cartAssertConfigProductPage] StorefrontCheckConfigurableProductActionGroup");
		$cartGrabConfigProductPageImageSrc1 = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: cartGrabConfigProductPageImageSrc1
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $cartGrabConfigProductPageImageSrc1); // stepKey: cartAssertConfigProductPageImageNotDefault1
		$I->selectOption("#attribute" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_id', 'test'), $I->retrieveEntityField('createConfigProductAttributeOption2', 'option[store_labels][1][label]', 'test')); // stepKey: cartConfigProductFillOption
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForConfigurableProductOptionloaded
		$I->comment("Entering Action Group [cartAssertConfigProductWithOptionPage] StorefrontCheckConfigurableProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertConfigProductWithOptionPage
		$I->seeInTitle($I->retrieveEntityField('createConfigProduct', 'name', 'test')); // stepKey: AssertProductNameInTitleCartAssertConfigProductWithOptionPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameCartAssertConfigProductWithOptionPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuCartAssertConfigProductWithOptionPage
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct2', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceCartAssertConfigProductWithOptionPage
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCartAssertConfigProductWithOptionPage
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartCartAssertConfigProductWithOptionPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionCartAssertConfigProductWithOptionPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionCartAssertConfigProductWithOptionPage
		$I->comment("Exiting Action Group [cartAssertConfigProductWithOptionPage] StorefrontCheckConfigurableProductActionGroup");
		$cartGrabConfigProductPageImageSrc2 = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: cartGrabConfigProductPageImageSrc2
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $cartGrabConfigProductPageImageSrc2); // stepKey: cartAssertConfigProductPageImageNotDefault2
		$I->comment("Entering Action Group [cartAddConfigProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartCartAddConfigProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddConfigProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddConfigProductToCart
		$I->see("You added " . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageCartAddConfigProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageCartAddConfigProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddConfigProductToCart
		$I->waitForText("3", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddConfigProductToCart
		$I->comment("Exiting Action Group [cartAddConfigProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Check simple product 1 in minicart");
		$I->comment("Entering Action Group [cartOpenMinicartAndCheckSimpleProduct1] StorefrontOpenMinicartAndCheckSimpleProductActionGroup");
		$I->waitForElement("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]", 30); // stepKey: waitForMinicartProductCartOpenMinicartAndCheckSimpleProduct1
		$I->click("a.showcart"); // stepKey: clickShowMinicartCartOpenMinicartAndCheckSimpleProduct1
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartCartOpenMinicartAndCheckSimpleProduct1WaitForPageLoad
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "//header//ol[@id='mini-cart']//div[@class='product-item-details'][.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceCartOpenMinicartAndCheckSimpleProduct1
		$I->comment("Exiting Action Group [cartOpenMinicartAndCheckSimpleProduct1] StorefrontOpenMinicartAndCheckSimpleProductActionGroup");
		$cartMinicartGrabSimpleProduct1ImageSrc = $I->grabAttributeFrom("header ol[id='mini-cart'] span[class='product-image-container'] img[alt='" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "']", "src"); // stepKey: cartMinicartGrabSimpleProduct1ImageSrc
		$I->assertNotRegExp('/placeholder\/thumbnail\.jpg/', $cartMinicartGrabSimpleProduct1ImageSrc); // stepKey: cartMinicartAssertSimpleProduct1ImageNotDefault
		$I->click("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: cartMinicartClickSimpleProduct1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForMinicartSimpleProduct1loaded
		$I->comment("Entering Action Group [cartAssertMinicartProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertMinicartProduct1Page
		$I->seeInTitle($I->retrieveEntityField('createSimpleProduct1', 'name', 'test')); // stepKey: AssertProductNameInTitleCartAssertMinicartProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), ".base"); // stepKey: assertProductNameCartAssertMinicartProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuCartAssertMinicartProduct1Page
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceCartAssertMinicartProduct1Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCartAssertMinicartProduct1Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartCartAssertMinicartProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionCartAssertMinicartProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionCartAssertMinicartProduct1Page
		$I->comment("Exiting Action Group [cartAssertMinicartProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$cartMinicartGrabSimpleProduct1PageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: cartMinicartGrabSimpleProduct1PageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $cartMinicartGrabSimpleProduct1PageImageSrc); // stepKey: cartMinicartAssertSimpleProduct1PageImageNotDefault
		$I->comment("Entering Action Group [cartOpenMinicartAndCheckSimpleProduct2] StorefrontOpenMinicartAndCheckSimpleProductActionGroup");
		$I->waitForElement("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]", 30); // stepKey: waitForMinicartProductCartOpenMinicartAndCheckSimpleProduct2
		$I->click("a.showcart"); // stepKey: clickShowMinicartCartOpenMinicartAndCheckSimpleProduct2
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartCartOpenMinicartAndCheckSimpleProduct2WaitForPageLoad
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct2', 'price', 'test') . ".00", "//header//ol[@id='mini-cart']//div[@class='product-item-details'][.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceCartOpenMinicartAndCheckSimpleProduct2
		$I->comment("Exiting Action Group [cartOpenMinicartAndCheckSimpleProduct2] StorefrontOpenMinicartAndCheckSimpleProductActionGroup");
		$I->comment("Check simple product 2 in minicart");
		$cartMinicartGrabSimpleProduct2ImageSrc = $I->grabAttributeFrom("header ol[id='mini-cart'] span[class='product-image-container'] img[alt='" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "']", "src"); // stepKey: cartMinicartGrabSimpleProduct2ImageSrc
		$I->assertNotRegExp('/placeholder\/thumbnail\.jpg/', $cartMinicartGrabSimpleProduct2ImageSrc); // stepKey: cartMinicartAssertSimpleProduct2ImageNotDefault
		$I->click("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: cartMinicartClickSimpleProduct2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForMinicartSimpleProduct2loaded
		$I->comment("Entering Action Group [cartAssertMinicartProduct2Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertMinicartProduct2Page
		$I->seeInTitle($I->retrieveEntityField('createSimpleProduct2', 'name', 'test')); // stepKey: AssertProductNameInTitleCartAssertMinicartProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), ".base"); // stepKey: assertProductNameCartAssertMinicartProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuCartAssertMinicartProduct2Page
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct2', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceCartAssertMinicartProduct2Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCartAssertMinicartProduct2Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartCartAssertMinicartProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionCartAssertMinicartProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionCartAssertMinicartProduct2Page
		$I->comment("Exiting Action Group [cartAssertMinicartProduct2Page] StorefrontCheckSimpleProductActionGroup");
		$cartMinicartGrabSimpleProduct2PageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: cartMinicartGrabSimpleProduct2PageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $cartMinicartGrabSimpleProduct2PageImageSrc); // stepKey: cartMinicartAssertSimpleProduct2PageImageNotDefault
		$I->comment("Check configurable product in minicart");
		$I->comment("Entering Action Group [cartOpenMinicartAndCheckConfigProduct] StorefrontOpenMinicartAndCheckConfigurableProductActionGroup");
		$I->waitForElement("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]", 30); // stepKey: waitForMinicartProductCartOpenMinicartAndCheckConfigProduct
		$I->click("a.showcart"); // stepKey: clickShowMinicartCartOpenMinicartAndCheckConfigProduct
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartCartOpenMinicartAndCheckConfigProductWaitForPageLoad
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct2', 'price', 'test') . ".00", "//header//ol[@id='mini-cart']//div[@class='product-item-details'][.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceCartOpenMinicartAndCheckConfigProduct
		$I->comment("Exiting Action Group [cartOpenMinicartAndCheckConfigProduct] StorefrontOpenMinicartAndCheckConfigurableProductActionGroup");
		$cartMinicartGrabConfigProductImageSrc = $I->grabAttributeFrom("header ol[id='mini-cart'] span[class='product-image-container'] img[alt='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "']", "src"); // stepKey: cartMinicartGrabConfigProductImageSrc
		$I->assertNotRegExp('/placeholder\/thumbnail\.jpg/', $cartMinicartGrabConfigProductImageSrc); // stepKey: cartMinicartAssertConfigProductImageNotDefault
		$I->click("//header//ol[@id='mini-cart']//div[@class='product-item-details'][.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//span[.='See Details']"); // stepKey: cartMinicartClickConfigProductDetails
		$I->see($I->retrieveEntityField('createConfigProductAttributeOption2', 'option[store_labels][1][label]', 'test'), "//header//ol[@id='mini-cart']//div[@class='product-item-details'][.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//dt[@class='label' and .='" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "']/following-sibling::dd[@class='values']//span"); // stepKey: cartMinicartCheckConfigProductOption
		$I->click("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: cartMinicartClickConfigProduct
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForMinicartConfigProductloaded
		$I->comment("Entering Action Group [cartAssertMinicartConfigProductPage] StorefrontCheckConfigurableProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertMinicartConfigProductPage
		$I->seeInTitle($I->retrieveEntityField('createConfigProduct', 'name', 'test')); // stepKey: AssertProductNameInTitleCartAssertMinicartConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameCartAssertMinicartConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuCartAssertMinicartConfigProductPage
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceCartAssertMinicartConfigProductPage
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCartAssertMinicartConfigProductPage
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartCartAssertMinicartConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionCartAssertMinicartConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionCartAssertMinicartConfigProductPage
		$I->comment("Exiting Action Group [cartAssertMinicartConfigProductPage] StorefrontCheckConfigurableProductActionGroup");
		$cartMinicartGrabConfigProductPageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: cartMinicartGrabConfigProductPageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $cartMinicartGrabConfigProductPageImageSrc); // stepKey: cartMinicartAssertConfigProductPageImageNotDefault
		$I->comment("Check cart information");
		$I->comment("Entering Action Group [cartOpenCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageCartOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartCartOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartCartOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkCartOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkCartOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartCartOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartCartOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartCartOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartCartOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [cartOpenCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [cartAssertCart] StorefrontCheckCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCartAssertCart
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCartAssertCart
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCartAssertCart
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCartAssertCart
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCartAssertCartWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCartAssertCart
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCartAssertCartWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCartAssertCart
		$I->see("480.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCartAssertCart
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCartAssertCart
		$I->waitForText("15.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCartAssertCart
		$I->see("495.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCartAssertCart
		$I->comment("Exiting Action Group [cartAssertCart] StorefrontCheckCartActionGroup");
		$I->comment("Check simple product 1 in cart");
		$I->comment("Entering Action Group [cartAssertCartSimpleProduct1] StorefrontCheckCartSimpleProductActionGroup");
		$I->seeElement("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: assertProductNameCartAssertCartSimpleProduct1
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceCartAssertCartSimpleProduct1
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: assertProductQuantityCartAssertCartSimpleProduct1
		$I->comment("Exiting Action Group [cartAssertCartSimpleProduct1] StorefrontCheckCartSimpleProductActionGroup");
		$cartCartGrabSimpleProduct1ImageSrc = $I->grabAttributeFrom("//main//table[@id='shopping-cart-table']//tbody//tr//img[contains(@class, 'product-image-photo') and @alt='" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "']", "src"); // stepKey: cartCartGrabSimpleProduct1ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $cartCartGrabSimpleProduct1ImageSrc); // stepKey: cartCartAssertSimpleProduct1ImageNotDefault
		$I->click("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: cartClickCartSimpleProduct1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartSimpleProduct1loadedAgain
		$I->comment("Entering Action Group [cartAssertCartProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertCartProduct1Page
		$I->seeInTitle($I->retrieveEntityField('createSimpleProduct1', 'name', 'test')); // stepKey: AssertProductNameInTitleCartAssertCartProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), ".base"); // stepKey: assertProductNameCartAssertCartProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuCartAssertCartProduct1Page
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceCartAssertCartProduct1Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCartAssertCartProduct1Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartCartAssertCartProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionCartAssertCartProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionCartAssertCartProduct1Page
		$I->comment("Exiting Action Group [cartAssertCartProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$cartCartGrabSimpleProduct2PageImageSrc1 = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: cartCartGrabSimpleProduct2PageImageSrc1
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $cartCartGrabSimpleProduct2PageImageSrc1); // stepKey: cartCartAssertSimpleProduct2PageImageNotDefault1
		$I->comment("Check simple product 2 in cart");
		$I->comment("Entering Action Group [cartOpenCart1] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageCartOpenCart1
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartCartOpenCart1
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartCartOpenCart1WaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkCartOpenCart1
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkCartOpenCart1WaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartCartOpenCart1
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartCartOpenCart1WaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartCartOpenCart1
		$I->waitForPageLoad(30); // stepKey: clickCartCartOpenCart1WaitForPageLoad
		$I->comment("Exiting Action Group [cartOpenCart1] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [cartAssertCartSimpleProduct2] StorefrontCheckCartSimpleProductActionGroup");
		$I->seeElement("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: assertProductNameCartAssertCartSimpleProduct2
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct2', 'price', 'test') . ".00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceCartAssertCartSimpleProduct2
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: assertProductQuantityCartAssertCartSimpleProduct2
		$I->comment("Exiting Action Group [cartAssertCartSimpleProduct2] StorefrontCheckCartSimpleProductActionGroup");
		$cartCartGrabSimpleProduct2ImageSrc = $I->grabAttributeFrom("//main//table[@id='shopping-cart-table']//tbody//tr//img[contains(@class, 'product-image-photo') and @alt='" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "']", "src"); // stepKey: cartCartGrabSimpleProduct2ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $cartCartGrabSimpleProduct2ImageSrc); // stepKey: cartCartAssertSimpleProduct2ImageNotDefault
		$I->click("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: cartClickCartSimpleProduct2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartSimpleProduct2loaded
		$I->comment("Entering Action Group [cartAssertCartProduct2Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertCartProduct2Page
		$I->seeInTitle($I->retrieveEntityField('createSimpleProduct2', 'name', 'test')); // stepKey: AssertProductNameInTitleCartAssertCartProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), ".base"); // stepKey: assertProductNameCartAssertCartProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuCartAssertCartProduct2Page
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct2', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceCartAssertCartProduct2Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCartAssertCartProduct2Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartCartAssertCartProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionCartAssertCartProduct2Page
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionCartAssertCartProduct2Page
		$I->comment("Exiting Action Group [cartAssertCartProduct2Page] StorefrontCheckSimpleProductActionGroup");
		$cartCartGrabSimpleProduct2PageImageSrc2 = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: cartCartGrabSimpleProduct2PageImageSrc2
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $cartCartGrabSimpleProduct2PageImageSrc2); // stepKey: cartCartAssertSimpleProduct2PageImageNotDefault2
		$I->comment("Check configurable product in cart");
		$I->comment("Entering Action Group [cartOpenCart2] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageCartOpenCart2
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartCartOpenCart2
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartCartOpenCart2WaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkCartOpenCart2
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkCartOpenCart2WaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartCartOpenCart2
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartCartOpenCart2WaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartCartOpenCart2
		$I->waitForPageLoad(30); // stepKey: clickCartCartOpenCart2WaitForPageLoad
		$I->comment("Exiting Action Group [cartOpenCart2] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [cartAssertCartConfigProduct] StorefrontCheckCartConfigurableProductActionGroup");
		$I->seeElement("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: assertProductNameCartAssertCartConfigProduct
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct2', 'price', 'test') . ".00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceCartAssertCartConfigProduct
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: assertProductQuantityCartAssertCartConfigProduct
		$I->comment("Exiting Action Group [cartAssertCartConfigProduct] StorefrontCheckCartConfigurableProductActionGroup");
		$cartCartGrabConfigProduct2ImageSrc = $I->grabAttributeFrom("//main//table[@id='shopping-cart-table']//tbody//tr//img[contains(@class, 'product-image-photo') and @alt='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "']", "src"); // stepKey: cartCartGrabConfigProduct2ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $cartCartGrabConfigProduct2ImageSrc); // stepKey: cartCartAssertConfigProduct2ImageNotDefault
		$I->see($I->retrieveEntityField('createConfigProductAttributeOption2', 'option[store_labels][1][label]', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[.//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//dl[@class='item-options']//dt[.='" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "']/following-sibling::dd[1]"); // stepKey: cartCheckConfigProductOption
		$I->click("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: cartClickCartConfigProduct
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartConfigProductloaded
		$I->comment("Entering Action Group [cartAssertCartConfigProductPage] StorefrontCheckConfigurableProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCartAssertCartConfigProductPage
		$I->seeInTitle($I->retrieveEntityField('createConfigProduct', 'name', 'test')); // stepKey: AssertProductNameInTitleCartAssertCartConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameCartAssertCartConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuCartAssertCartConfigProductPage
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceCartAssertCartConfigProductPage
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCartAssertCartConfigProductPage
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartCartAssertCartConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionCartAssertCartConfigProductPage
		$I->see($I->retrieveEntityField('createConfigProduct', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionCartAssertCartConfigProductPage
		$I->comment("Exiting Action Group [cartAssertCartConfigProductPage] StorefrontCheckConfigurableProductActionGroup");
		$cartCartGrabConfigProductPageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: cartCartGrabConfigProductPageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $cartCartGrabConfigProductPageImageSrc); // stepKey: cartCartAssertConfigProductPageImageNotDefault
		$I->comment("End of adding products to cart");
		$I->comment("Start of comparing products");
		$I->comment("Step 4: User compares products");
		$I->comment("Add Simple Product 1 to comparison");
		$I->comment("Add simple product 1 to comparison");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: compareClickCategory
		$I->waitForPageLoad(30); // stepKey: compareClickCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCategoryloaded
		$I->comment("Entering Action Group [compareAssertCategory] StorefrontCheckCategoryActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCompareAssertCategory
		$I->seeInTitle($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: assertCategoryNameInTitleCompareAssertCategory
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameCompareAssertCategory
		$I->see("3", "#toolbar-amount span"); // stepKey: assertProductCountCompareAssertCategory
		$I->comment("Exiting Action Group [compareAssertCategory] StorefrontCheckCategoryActionGroup");
		$I->comment("Entering Action Group [compareAssertSimpleProduct1] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]", 30); // stepKey: waitForProductCompareAssertSimpleProduct1
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: assertProductNameCompareAssertSimpleProduct1
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceCompareAssertSimpleProduct1
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCompareAssertSimpleProduct1
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartCompareAssertSimpleProduct1
		$I->comment("Exiting Action Group [compareAssertSimpleProduct1] StorefrontCheckCategorySimpleProductActionGroup");
		$I->comment("@TODO: Move Image check to action group after MQE-697 is fixed");
		$compareGrabSimpleProduct1ImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: compareGrabSimpleProduct1ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $compareGrabSimpleProduct1ImageSrc); // stepKey: compareAssertSimpleProduct1ImageNotDefault
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: compareClickSimpleProduct1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCompareSimpleProduct1loaded
		$I->comment("Entering Action Group [compareAssertProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCompareAssertProduct1Page
		$I->seeInTitle($I->retrieveEntityField('createSimpleProduct1', 'name', 'test')); // stepKey: AssertProductNameInTitleCompareAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), ".base"); // stepKey: assertProductNameCompareAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuCompareAssertProduct1Page
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceCompareAssertProduct1Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockCompareAssertProduct1Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartCompareAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionCompareAssertProduct1Page
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionCompareAssertProduct1Page
		$I->comment("Exiting Action Group [compareAssertProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$I->comment("@TODO: Move Image check to action group after MQE-697 is fixed");
		$compareGrabSimpleProduct1PageImageSrc = $I->grabAttributeFrom("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[@class='fotorama__img']", "src"); // stepKey: compareGrabSimpleProduct1PageImageSrc
		$I->assertNotRegExp('/placeholder\/image\.jpg/', $compareGrabSimpleProduct1PageImageSrc); // stepKey: compareAssertSimpleProduct2PageImageNotDefault
		$I->comment("Entering Action Group [compareAddSimpleProduct1ToCompare] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareCompareAddSimpleProduct1ToCompare
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageCompareAddSimpleProduct1ToCompare
		$I->see("You added product " . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageCompareAddSimpleProduct1ToCompare
		$I->comment("Exiting Action Group [compareAddSimpleProduct1ToCompare] StorefrontAddProductToCompareActionGroup");
		$I->comment("Add Simple Product 2 to comparison");
		$I->comment("Add simple product 2 to comparison");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: compareClickCategory1
		$I->waitForPageLoad(30); // stepKey: compareClickCategory1WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCompareCategory1loaded
		$I->comment("Entering Action Group [compareAssertCategory1] StorefrontCheckCategoryActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCompareAssertCategory1
		$I->seeInTitle($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: assertCategoryNameInTitleCompareAssertCategory1
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameCompareAssertCategory1
		$I->see("3", "#toolbar-amount span"); // stepKey: assertProductCountCompareAssertCategory1
		$I->comment("Exiting Action Group [compareAssertCategory1] StorefrontCheckCategoryActionGroup");
		$I->comment("Entering Action Group [compareAssertSimpleProduct2] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]", 30); // stepKey: waitForProductCompareAssertSimpleProduct2
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: assertProductNameCompareAssertSimpleProduct2
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct2', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceCompareAssertSimpleProduct2
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCompareAssertSimpleProduct2
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartCompareAssertSimpleProduct2
		$I->comment("Exiting Action Group [compareAssertSimpleProduct2] StorefrontCheckCategorySimpleProductActionGroup");
		$I->comment("@TODO: Move Image check to action group after MQE-697 is fixed");
		$compareGrabSimpleProduct2ImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: compareGrabSimpleProduct2ImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $compareGrabSimpleProduct2ImageSrc); // stepKey: compareAssertSimpleProduct2ImageNotDefault
		$I->comment("Entering Action Group [compareAddSimpleProduct2ToCompare] StorefrontAddCategoryProductToCompareActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCompareAddSimpleProduct2ToCompare
		$I->click("//*[contains(@class,'product-item-info')][descendant::a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//a[contains(@class, 'tocompare')]"); // stepKey: clickAddProductToCompareCompareAddSimpleProduct2ToCompare
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddCategoryProductToCompareSuccessMessageCompareAddSimpleProduct2ToCompare
		$I->see("You added product " . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddCategoryProductToCompareSuccessMessageCompareAddSimpleProduct2ToCompare
		$I->comment("Exiting Action Group [compareAddSimpleProduct2ToCompare] StorefrontAddCategoryProductToCompareActionGroup");
		$I->comment("Add Configurable Product to comparison");
		$I->comment("Entering Action Group [compareAssertConfigProduct] StorefrontCheckCategoryConfigurableProductActionGroup");
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: assertProductNameCompareAssertConfigProduct
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceCompareAssertConfigProduct
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCompareAssertConfigProduct
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartCompareAssertConfigProduct
		$I->comment("Exiting Action Group [compareAssertConfigProduct] StorefrontCheckCategoryConfigurableProductActionGroup");
		$compareGrabConfigProductImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: compareGrabConfigProductImageSrc
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $compareGrabConfigProductImageSrc); // stepKey: compareAssertConfigProductImageNotDefault
		$I->comment("Entering Action Group [compareAddConfigProductToCompare] StorefrontAddCategoryProductToCompareActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductCompareAddConfigProductToCompare
		$I->click("//*[contains(@class,'product-item-info')][descendant::a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//a[contains(@class, 'tocompare')]"); // stepKey: clickAddProductToCompareCompareAddConfigProductToCompare
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddCategoryProductToCompareSuccessMessageCompareAddConfigProductToCompare
		$I->see("You added product " . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddCategoryProductToCompareSuccessMessageCompareAddConfigProductToCompare
		$I->comment("Exiting Action Group [compareAddConfigProductToCompare] StorefrontAddCategoryProductToCompareActionGroup");
		$I->comment("Check simple product 1 in comparison sidebar");
		$I->comment("Entering Action Group [compareSimpleProduct1InSidebar] StorefrontCheckCompareSidebarProductActionGroup");
		$I->waitForElement("//main//ol[@id='compare-items']//a[@class='product-item-link'][text()='" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "']", 30); // stepKey: waitForProductCompareSimpleProduct1InSidebar
		$I->comment("Exiting Action Group [compareSimpleProduct1InSidebar] StorefrontCheckCompareSidebarProductActionGroup");
		$I->comment("Check products in comparison sidebar");
		$I->comment("Check simple product 1 in comparison sidebar");
		$I->comment("Check simple product 2 in comparison sidebar");
		$I->comment("Check simple product 2 in comparison sidebar");
		$I->comment("Entering Action Group [compareSimpleProduct2InSidebar] StorefrontCheckCompareSidebarProductActionGroup");
		$I->waitForElement("//main//ol[@id='compare-items']//a[@class='product-item-link'][text()='" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "']", 30); // stepKey: waitForProductCompareSimpleProduct2InSidebar
		$I->comment("Exiting Action Group [compareSimpleProduct2InSidebar] StorefrontCheckCompareSidebarProductActionGroup");
		$I->comment("Add Configurable Product in comparison sidebar");
		$I->comment("Entering Action Group [compareConfigProductInSidebar] StorefrontCheckCompareSidebarProductActionGroup");
		$I->waitForElement("//main//ol[@id='compare-items']//a[@class='product-item-link'][text()='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "']", 30); // stepKey: waitForProductCompareConfigProductInSidebar
		$I->comment("Exiting Action Group [compareConfigProductInSidebar] StorefrontCheckCompareSidebarProductActionGroup");
		$I->comment("Check simple product 1 on comparison page");
		$I->comment("Entering Action Group [compareOpenComparePage] StorefrontOpenAndCheckComparisionActionGroup");
		$I->click("//main//div[contains(@class, 'block-compare')]//a[contains(@class, 'action compare')]"); // stepKey: clickCompareCompareOpenComparePage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForComparePageloadedCompareOpenComparePage
		$I->seeInCurrentUrl("catalog/product_compare/index"); // stepKey: checkUrlCompareOpenComparePage
		$I->seeInTitle("Products Comparison List"); // stepKey: assertPageNameInTitleCompareOpenComparePage
		$I->see("Compare Products", "//*[@id='maincontent']//h1//span"); // stepKey: assertPageNameCompareOpenComparePage
		$I->comment("Exiting Action Group [compareOpenComparePage] StorefrontOpenAndCheckComparisionActionGroup");
		$I->comment("Check products on comparison page");
		$I->comment("Check simple product 1 on comparison page");
		$I->comment("Entering Action Group [compareAssertSimpleProduct1InComparison] StorefrontCheckCompareSimpleProductActionGroup");
		$I->seeElement("//*[@id='product-comparison']//tr//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: assertProductNameCompareAssertSimpleProduct1InComparison
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPrice1CompareAssertSimpleProduct1InComparison
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'sku', 'test'), "//*[@id='product-comparison']//tr[.//th[./span[contains(text(), 'SKU')]]]//td[count(//*[@id='product-comparison']//tr//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]/preceding-sibling::td)+1]/div"); // stepKey: assertProductPrice2CompareAssertSimpleProduct1InComparison
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->seeElement("//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: assertProductAddToCartCompareAssertSimpleProduct1InComparison
		$I->comment("Exiting Action Group [compareAssertSimpleProduct1InComparison] StorefrontCheckCompareSimpleProductActionGroup");
		$I->comment("@TODO: Move Image check to action group after MQE-697 is fixed");
		$compareGrabSimpleProduct1ImageSrcInComparison = $I->grabAttributeFrom("//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: compareGrabSimpleProduct1ImageSrcInComparison
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $compareGrabSimpleProduct1ImageSrcInComparison); // stepKey: compareAssertSimpleProduct1ImageNotDefaultInComparison
		$I->comment("Check simple product2 on comparison page");
		$I->comment("Check simple product 2 on comparison page");
		$I->comment("Entering Action Group [compareAssertSimpleProduct2InComparison] StorefrontCheckCompareSimpleProductActionGroup");
		$I->seeElement("//*[@id='product-comparison']//tr//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: assertProductNameCompareAssertSimpleProduct2InComparison
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct2', 'price', 'test') . ".00", "//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPrice1CompareAssertSimpleProduct2InComparison
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'sku', 'test'), "//*[@id='product-comparison']//tr[.//th[./span[contains(text(), 'SKU')]]]//td[count(//*[@id='product-comparison']//tr//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]/preceding-sibling::td)+1]/div"); // stepKey: assertProductPrice2CompareAssertSimpleProduct2InComparison
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->seeElement("//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: assertProductAddToCartCompareAssertSimpleProduct2InComparison
		$I->comment("Exiting Action Group [compareAssertSimpleProduct2InComparison] StorefrontCheckCompareSimpleProductActionGroup");
		$I->comment("@TODO: Move Image check to action group after MQE-697 is fixed");
		$compareGrabSimpleProduct2ImageSrcInComparison = $I->grabAttributeFrom("//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: compareGrabSimpleProduct2ImageSrcInComparison
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $compareGrabSimpleProduct2ImageSrcInComparison); // stepKey: compareAssertSimpleProduct2ImageNotDefaultInComparison
		$I->comment("Add Configurable Product on comparison page");
		$I->comment("Entering Action Group [compareAssertConfigProductInComparison] StorefrontCheckCompareConfigurableProductActionGroup");
		$I->seeElement("//*[@id='product-comparison']//tr//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: assertProductNameCompareAssertConfigProductInComparison
		$I->see("$" . $I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceCompareAssertConfigProductInComparison
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), "//*[@id='product-comparison']//tr[.//th[./span[contains(text(), 'SKU')]]]//td[count(//*[@id='product-comparison']//tr//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]/preceding-sibling::td)+1]/div"); // stepKey: assertProductSkuCompareAssertConfigProductInComparison
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->seeElement("//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: assertProductAddToCartCompareAssertConfigProductInComparison
		$I->comment("Exiting Action Group [compareAssertConfigProductInComparison] StorefrontCheckCompareConfigurableProductActionGroup");
		$compareGrabConfigProductImageSrcInComparison = $I->grabAttributeFrom("//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: compareGrabConfigProductImageSrcInComparison
		$I->assertNotRegExp('/placeholder\/small_image\.jpg/', $compareGrabConfigProductImageSrcInComparison); // stepKey: compareAssertConfigProductImageNotDefaultInComparison
		$I->comment("Clear comparison sidebar");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: compareClickCategoryBeforeClear
		$I->waitForPageLoad(30); // stepKey: compareClickCategoryBeforeClearWaitForPageLoad
		$I->comment("Clear comparison sidebar");
		$I->comment("Entering Action Group [compareAssertCategory2] StorefrontCheckCategoryActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCompareAssertCategory2
		$I->seeInTitle($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: assertCategoryNameInTitleCompareAssertCategory2
		$I->see($I->retrieveEntityField('createCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameCompareAssertCategory2
		$I->see("3", "#toolbar-amount span"); // stepKey: assertProductCountCompareAssertCategory2
		$I->comment("Exiting Action Group [compareAssertCategory2] StorefrontCheckCategoryActionGroup");
		$I->comment("Entering Action Group [compareClearCompare] StorefrontClearCompareActionGroup");
		$I->waitForElementVisible("//main//div[contains(@class, 'block-compare')]//a[contains(@class, 'action clear')]", 30); // stepKey: waitForClearAllCompareClearCompare
		$I->click("//main//div[contains(@class, 'block-compare')]//a[contains(@class, 'action clear')]"); // stepKey: clickClearAllCompareClearCompare
		$I->waitForElementVisible("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]", 30); // stepKey: waitForClearOkCompareClearCompare
		$I->waitForPageLoad(30); // stepKey: waitForClearOkCompareClearCompareWaitForPageLoad
		$I->scrollTo("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: scrollToClearOkCompareClearCompare
		$I->waitForPageLoad(30); // stepKey: scrollToClearOkCompareClearCompareWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickClearOkCompareClearCompare
		$I->waitForPageLoad(30); // stepKey: clickClearOkCompareClearCompareWaitForPageLoad
		$I->waitForElementVisible("//main//div[contains(@class, 'messages')]//div[contains(@class, 'message')]/div[contains(text(), 'You cleared the comparison list.')]", 30); // stepKey: assertMessageClearedCompareClearCompare
		$I->waitForElementVisible("//main//div[contains(@class, 'block-compare')]//div[@class='empty']", 30); // stepKey: assertNoItemsCompareClearCompare
		$I->comment("Exiting Action Group [compareClearCompare] StorefrontClearCompareActionGroup");
		$I->comment("End of Comparing Products");
		$I->comment("Start of using coupon code");
		$I->comment("Entering Action Group [couponOpenCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageCouponOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartCouponOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartCouponOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkCouponOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkCouponOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartCouponOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartCouponOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartCouponOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartCouponOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [couponOpenCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [couponApplyCoupon] StorefrontApplyCouponActionGroup");
		$I->waitForElement("#block-discount-heading", 30); // stepKey: waitForCouponHeaderCouponApplyCoupon
		$I->conditionalClick("#block-discount-heading", ".block.discount.active", false); // stepKey: clickCouponHeaderCouponApplyCoupon
		$I->waitForElementVisible("#coupon_code", 30); // stepKey: waitForCouponFieldCouponApplyCoupon
		$I->fillField("#coupon_code", $I->retrieveEntityField('createSalesRuleCoupon', 'code', 'test')); // stepKey: fillCouponFieldCouponApplyCoupon
		$I->click("#discount-coupon-form button[class*='apply']"); // stepKey: clickApplyButtonCouponApplyCoupon
		$I->waitForPageLoad(30); // stepKey: clickApplyButtonCouponApplyCouponWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCouponApplyCoupon
		$I->comment("Exiting Action Group [couponApplyCoupon] StorefrontApplyCouponActionGroup");
		$I->comment("Entering Action Group [couponCheckAppliedDiscount] StorefrontCheckCouponAppliedActionGroup");
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[.//th//span[contains(@class, 'discount coupon')]]//td//span//span[@class='price']", 30); // stepKey: waitForDiscountTotalCouponCheckAppliedDiscount
		$I->see($I->retrieveEntityField('createSalesRule', 'store_labels[1][store_label]', 'test'), "//*[@id='cart-totals']//tr[.//th//span[contains(@class, 'discount coupon')]]"); // stepKey: assertDiscountLabelCouponCheckAppliedDiscount
		$I->see("-$48.00", "//*[@id='cart-totals']//tr[.//th//span[contains(@class, 'discount coupon')]]//td//span//span[@class='price']"); // stepKey: assertDiscountTotalCouponCheckAppliedDiscount
		$I->comment("Exiting Action Group [couponCheckAppliedDiscount] StorefrontCheckCouponAppliedActionGroup");
		$I->comment("Entering Action Group [couponCheckCartWithDiscount] StorefrontCheckCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCouponCheckCartWithDiscount
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCouponCheckCartWithDiscount
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCouponCheckCartWithDiscount
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCouponCheckCartWithDiscount
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCouponCheckCartWithDiscountWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCouponCheckCartWithDiscount
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCouponCheckCartWithDiscountWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCouponCheckCartWithDiscount
		$I->see("480.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCouponCheckCartWithDiscount
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCouponCheckCartWithDiscount
		$I->waitForText("15.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCouponCheckCartWithDiscount
		$I->see("447.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCouponCheckCartWithDiscount
		$I->comment("Exiting Action Group [couponCheckCartWithDiscount] StorefrontCheckCartActionGroup");
		$I->comment("Entering Action Group [couponCancelCoupon] StorefrontCancelCouponActionGroup");
		$I->waitForElement("#block-discount-heading", 30); // stepKey: waitForCouponHeaderCouponCancelCoupon
		$I->conditionalClick("#block-discount-heading", ".block.discount.active", false); // stepKey: clickCouponHeaderCouponCancelCoupon
		$I->waitForElementVisible("#coupon_code", 30); // stepKey: waitForCouponFieldCouponCancelCoupon
		$I->click("#discount-coupon-form button[class*='cancel']"); // stepKey: clickCancelButtonCouponCancelCoupon
		$I->waitForPageLoad(30); // stepKey: clickCancelButtonCouponCancelCouponWaitForPageLoad
		$I->comment("Exiting Action Group [couponCancelCoupon] StorefrontCancelCouponActionGroup");
		$I->comment("Entering Action Group [cartAssertCartAfterCancelCoupon] StorefrontCheckCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCartAssertCartAfterCancelCoupon
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCartAssertCartAfterCancelCoupon
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCartAssertCartAfterCancelCoupon
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCartAssertCartAfterCancelCoupon
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCartAssertCartAfterCancelCouponWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCartAssertCartAfterCancelCoupon
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCartAssertCartAfterCancelCouponWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCartAssertCartAfterCancelCoupon
		$I->see("480.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCartAssertCartAfterCancelCoupon
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCartAssertCartAfterCancelCoupon
		$I->waitForText("15.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCartAssertCartAfterCancelCoupon
		$I->see("495.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCartAssertCartAfterCancelCoupon
		$I->comment("Exiting Action Group [cartAssertCartAfterCancelCoupon] StorefrontCheckCartActionGroup");
		$I->comment("End of using coupon code");
		$I->comment("Start of checking out");
		$I->comment("Entering Action Group [guestGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGuestGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGuestGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGuestGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGuestGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGuestGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGuestGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [guestGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [guestCheckoutFillingShippingSection] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldGuestCheckoutFillingShippingSection
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailGuestCheckoutFillingShippingSection
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameGuestCheckoutFillingShippingSection
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameGuestCheckoutFillingShippingSection
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetGuestCheckoutFillingShippingSection
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityGuestCheckoutFillingShippingSection
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionGuestCheckoutFillingShippingSection
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeGuestCheckoutFillingShippingSection
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneGuestCheckoutFillingShippingSection
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestCheckoutFillingShippingSection
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input", 30); // stepKey: waitForShippingMethodGuestCheckoutFillingShippingSection
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodGuestCheckoutFillingShippingSection
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingSectionWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutFillingShippingSectionWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutFillingShippingSection
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutFillingShippingSection
		$I->comment("Exiting Action Group [guestCheckoutFillingShippingSection] GuestCheckoutFillingShippingSectionActionGroup");
		$I->comment("Check order summary in checkout");
		$I->comment("Entering Action Group [guestCheckoutCheckOrderSummary] CheckOrderSummaryInCheckoutActionGroup");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutCheckOrderSummary
		$I->see("480.00", "//tr[@class='totals sub']//span[@class='price']"); // stepKey: assertSubtotalGuestCheckoutCheckOrderSummary
		$I->see("15.00", "//tr[@class='totals shipping excl']//span[@class='price']"); // stepKey: assertShippingGuestCheckoutCheckOrderSummary
		$I->see("Flat Rate - Fixed", "//tr[@class='totals shipping excl']//span[@class='value']"); // stepKey: assertShippingMethodGuestCheckoutCheckOrderSummary
		$I->see("495.00", "//tr[@class='grand totals']//span[@class='price']"); // stepKey: assertTotalGuestCheckoutCheckOrderSummary
		$I->comment("Exiting Action Group [guestCheckoutCheckOrderSummary] CheckOrderSummaryInCheckoutActionGroup");
		$I->comment("Check ship to information in checkout");
		$I->comment("Entering Action Group [guestCheckoutCheckShipToInformation] CheckShipToInformationInCheckoutActionGroup");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutCheckShipToInformation
		$I->see("John", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: assertShipToInformationFirstNameGuestCheckoutCheckShipToInformation
		$I->see("Doe", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: assertShipToInformationLastNameGuestCheckoutCheckShipToInformation
		$I->see("7700 W Parmer Ln", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: assertShipToInformationStreetGuestCheckoutCheckShipToInformation
		$I->see("Austin", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: assertShipToInformationCityGuestCheckoutCheckShipToInformation
		$I->see("Texas", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: assertShipToInformationStateGuestCheckoutCheckShipToInformation
		$I->see("78729", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: assertShipToInformationPostcodeGuestCheckoutCheckShipToInformation
		$I->see("1234568910", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: assertShipToInformationTelephoneGuestCheckoutCheckShipToInformation
		$I->comment("Exiting Action Group [guestCheckoutCheckShipToInformation] CheckShipToInformationInCheckoutActionGroup");
		$I->comment("Check shipping method in checkout");
		$I->comment("Entering Action Group [guestCheckoutCheckShippingMethod] CheckShippingMethodInCheckoutActionGroup");
		$I->waitForElementVisible("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutCheckShippingMethod
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedGuestCheckoutCheckShippingMethod
		$I->waitForElementVisible("//div[@class='ship-via']//div[@class='shipping-information-content']", 30); // stepKey: waitForShippingMethodInformationVisibleGuestCheckoutCheckShippingMethod
		$I->see("Flat Rate - Fixed", "//div[@class='ship-via']//div[@class='shipping-information-content']"); // stepKey: assertshippingMethodInformationGuestCheckoutCheckShippingMethod
		$I->comment("Exiting Action Group [guestCheckoutCheckShippingMethod] CheckShippingMethodInCheckoutActionGroup");
		$I->comment("Verify Simple Product 1 is in checkout cart items");
		$I->comment("Entering Action Group [guestCheckoutCheckSimpleProduct1InCartItems] CheckProductInCheckoutCartItemsActionGroup");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutCheckSimpleProduct1InCartItems
		$I->conditionalClick("div.block.items-in-cart", "div.block.items-in-cart", true); // stepKey: exposeMiniCartGuestCheckoutCheckSimpleProduct1InCartItems
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForCartItemGuestCheckoutCheckSimpleProduct1InCartItems
		$I->waitForElement("div.block.items-in-cart.active", 30); // stepKey: waitForCartItemsAreaActiveGuestCheckoutCheckSimpleProduct1InCartItems
		$I->waitForPageLoad(30); // stepKey: waitForCartItemsAreaActiveGuestCheckoutCheckSimpleProduct1InCartItemsWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), "ol.minicart-items"); // stepKey: seeProductInCartGuestCheckoutCheckSimpleProduct1InCartItems
		$I->comment("Exiting Action Group [guestCheckoutCheckSimpleProduct1InCartItems] CheckProductInCheckoutCartItemsActionGroup");
		$I->comment("Verify Simple Product 2 is in checkout cart items");
		$I->comment("Entering Action Group [guestCheckoutCheckSimpleProduct2InCartItems] CheckProductInCheckoutCartItemsActionGroup");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutCheckSimpleProduct2InCartItems
		$I->conditionalClick("div.block.items-in-cart", "div.block.items-in-cart", true); // stepKey: exposeMiniCartGuestCheckoutCheckSimpleProduct2InCartItems
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForCartItemGuestCheckoutCheckSimpleProduct2InCartItems
		$I->waitForElement("div.block.items-in-cart.active", 30); // stepKey: waitForCartItemsAreaActiveGuestCheckoutCheckSimpleProduct2InCartItems
		$I->waitForPageLoad(30); // stepKey: waitForCartItemsAreaActiveGuestCheckoutCheckSimpleProduct2InCartItemsWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), "ol.minicart-items"); // stepKey: seeProductInCartGuestCheckoutCheckSimpleProduct2InCartItems
		$I->comment("Exiting Action Group [guestCheckoutCheckSimpleProduct2InCartItems] CheckProductInCheckoutCartItemsActionGroup");
		$I->comment("Verify Configurable Product in checkout cart items");
		$I->comment("Entering Action Group [guestCheckoutCheckConfigurableProductInCartItems] CheckConfigurableProductInCheckoutCartItemsActionGroup");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutCheckConfigurableProductInCartItems
		$I->conditionalClick("div.block.items-in-cart", "div.block.items-in-cart", true); // stepKey: exposeMiniCartGuestCheckoutCheckConfigurableProductInCartItems
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForCartItemGuestCheckoutCheckConfigurableProductInCartItems
		$I->waitForElement("div.block.items-in-cart.active", 30); // stepKey: waitForCartItemsAreaActiveGuestCheckoutCheckConfigurableProductInCartItems
		$I->waitForPageLoad(30); // stepKey: waitForCartItemsAreaActiveGuestCheckoutCheckConfigurableProductInCartItemsWaitForPageLoad
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), "ol.minicart-items"); // stepKey: seeProductInCartGuestCheckoutCheckConfigurableProductInCartItems
		$I->conditionalClick("//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options']", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']", false); // stepKey: exposeProductOptionsGuestCheckoutCheckConfigurableProductInCartItems
		$I->see($I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test'), "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionLabelGuestCheckoutCheckConfigurableProductInCartItems
		$I->see($I->retrieveEntityField('createConfigProductAttributeOption2', 'option[store_labels][1][label]', 'test'), "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionValueGuestCheckoutCheckConfigurableProductInCartItems
		$I->comment("Exiting Action Group [guestCheckoutCheckConfigurableProductInCartItems] CheckConfigurableProductInCheckoutCartItemsActionGroup");
		$I->comment("Place order with check money order payment");
		$I->comment("Entering Action Group [guestSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestSelectCheckMoneyOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGuestSelectCheckMoneyOrderPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodGuestSelectCheckMoneyOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionGuestSelectCheckMoneyOrderPayment
		$I->comment("Exiting Action Group [guestSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [guestSeeBillingAddress] CheckBillingAddressInCheckoutActionGroup");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestSeeBillingAddress
		$I->see("John", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressFirstNameGuestSeeBillingAddress
		$I->see("Doe", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressLastNameGuestSeeBillingAddress
		$I->see("7700 W Parmer Ln", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressStreetGuestSeeBillingAddress
		$I->see("Austin", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressCityGuestSeeBillingAddress
		$I->see("Texas", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressStateGuestSeeBillingAddress
		$I->see("78729", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressPostcodeGuestSeeBillingAddress
		$I->see("1234568910", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressTelephoneGuestSeeBillingAddress
		$I->comment("Exiting Action Group [guestSeeBillingAddress] CheckBillingAddressInCheckoutActionGroup");
		$I->comment("Entering Action Group [guestPlaceorder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonGuestPlaceorder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonGuestPlaceorderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderGuestPlaceorder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderGuestPlaceorderWaitForPageLoad
		$I->see("Your order # is:", "div.checkout-success"); // stepKey: seeOrderNumberGuestPlaceorder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouGuestPlaceorder
		$I->comment("Exiting Action Group [guestPlaceorder] CheckoutPlaceOrderActionGroup");
		$I->comment("End of checking out");
	}
}
