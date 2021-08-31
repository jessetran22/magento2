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
 * @Title("[NO TESTCASEID]: Apply discount tier price and custom price values for simple product")
 * @Description("Apply discount tier price and custom price values for simple product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StoreFrontSimpleProductWithSpecialAndTierDiscountPriceTest.xml<br>")
 * @group Catalog
 */
class StoreFrontSimpleProductWithSpecialAndTierDiscountPriceTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createProductFields['price'] = "100.00";
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], $createProductFields); // stepKey: createProduct
		$I->createEntity("addTierPrice", "hook", "tierProductPriceDiscount", ["createProduct"], []); // stepKey: addTierPrice
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Apply discount tier price and custom price values for simple product"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontSimpleProductWithSpecialAndTierDiscountPriceTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [openAdminProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductOpenAdminProductEditPage
		$I->comment("Exiting Action Group [openAdminProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [addSpecialPriceToProduct] AddSpecialPriceToProductActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSpecialPriceToProduct
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkAddSpecialPriceToProduct
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkAddSpecialPriceToProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalAddSpecialPriceToProduct
		$I->waitForElementVisible("input[name='product[special_price]']", 30); // stepKey: waitSpecialPriceAddSpecialPriceToProduct
		$I->fillField("input[name='product[special_price]']", "65.00"); // stepKey: fillSpecialPriceAddSpecialPriceToProduct
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneAddSpecialPriceToProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneAddSpecialPriceToProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalGoneAddSpecialPriceToProduct
		$I->waitForElementNotVisible("input[name='product[special_price]']", 30); // stepKey: waitForCloseModalWindowAddSpecialPriceToProduct
		$I->comment("Exiting Action Group [addSpecialPriceToProduct] AddSpecialPriceToProductActionGroup");
		$I->comment("Entering Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductNameText] AssertStorefrontProductDetailPageNameActionGroup");
		$productNameTextAssertProductNameText = $I->grabTextFrom(".base"); // stepKey: productNameTextAssertProductNameText
		$I->assertEquals($I->retrieveEntityField('createProduct', 'name', 'test'), $productNameTextAssertProductNameText); // stepKey: assertProductNameOnProductPageAssertProductNameText
		$I->comment("Exiting Action Group [assertProductNameText] AssertStorefrontProductDetailPageNameActionGroup");
		$I->comment("Entering Action Group [assertProductTierPriceText] AssertStorefrontProductDetailPageTierPriceActionGroup");
		$tierPriceTextAssertProductTierPriceText = $I->grabTextFrom(".prices-tier li[class='item']"); // stepKey: tierPriceTextAssertProductTierPriceText
		$I->assertEquals("Buy 3 for $64.00 each and save 2%", $tierPriceTextAssertProductTierPriceText); // stepKey: assertTierPriceTextOnProductPageAssertProductTierPriceText
		$I->comment("Exiting Action Group [assertProductTierPriceText] AssertStorefrontProductDetailPageTierPriceActionGroup");
		$I->comment("Entering Action Group [assertProductFinalPriceText] AssertStorefrontProductDetailPageFinalPriceActionGroup");
		$productPriceTextAssertProductFinalPriceText = $I->grabTextFrom(".product-info-main [data-price-type='finalPrice']"); // stepKey: productPriceTextAssertProductFinalPriceText
		$I->assertEquals("$65.00", $productPriceTextAssertProductFinalPriceText); // stepKey: assertProductPriceOnProductPageAssertProductFinalPriceText
		$I->comment("Exiting Action Group [assertProductFinalPriceText] AssertStorefrontProductDetailPageFinalPriceActionGroup");
	}
}
