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
 * @Title("MC-12292: Check that simple products with MAP assigned to configurable product displayed correctly")
 * @Description("Check that simple products with MAP assigned to configurable product displayed correctly<h3>Test files</h3>app/code/Magento/Msrp/Test/Mftf/Test/StorefrontProductWithMapAssignedConfigProductIsCorrectTest.xml<br>")
 * @TestCaseId("MC-12292")
 * @group Msrp
 */
class StorefrontProductWithMapAssignedConfigProductIsCorrectTestCest
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
		$I->comment("Create the configurable product based on the data in the /data folder");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Make the configurable product have two options, that are children of the default attribute set");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigProductAttributeOption3", "hook", "productAttributeOption3", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption3
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->getEntity("getConfigAttributeOption3", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 3); // stepKey: getConfigAttributeOption3
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleProductWithPrice50", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleProductWithPrice60", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigChildProduct3", "hook", "ApiSimpleProductWithPrice70", ["createConfigProductAttribute", "getConfigAttributeOption3"], []); // stepKey: createConfigChildProduct3
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2", "getConfigAttributeOption3"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->createEntity("createConfigProductAddChild3", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct3"], []); // stepKey: createConfigProductAddChild3
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
		$I->deleteEntity("createConfigChildProduct3", "hook"); // stepKey: deleteConfigChildProduct3
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
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
	public function StorefrontProductWithMapAssignedConfigProductIsCorrectTest(AcceptanceTester $I)
	{
		$I->comment("Set Manufacturer's Suggested Retail Price to products");
		$I->comment("Entering Action Group [goToFirstChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1', 'id', 'test')); // stepKey: goToProductGoToFirstChildProductEditPage
		$I->comment("Exiting Action Group [goToFirstChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButton
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonWaitForPageLoad
		$I->waitForElement("//input[@name='product[msrp]']", 30); // stepKey: waitForMsrp
		$I->waitForPageLoad(30); // stepKey: waitForMsrpWaitForPageLoad
		$I->fillField("//input[@name='product[msrp]']", "55"); // stepKey: setMsrpForFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: setMsrpForFirstChildProductWaitForPageLoad
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButton
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonWaitForPageLoad
		$I->comment("Entering Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct1
		$I->comment("Exiting Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [goToSecondChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct2', 'id', 'test')); // stepKey: goToProductGoToSecondChildProductEditPage
		$I->comment("Exiting Action Group [goToSecondChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad1
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButton1
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButton1WaitForPageLoad
		$I->waitForElement("//input[@name='product[msrp]']", 30); // stepKey: waitForMsrp1
		$I->waitForPageLoad(30); // stepKey: waitForMsrp1WaitForPageLoad
		$I->fillField("//input[@name='product[msrp]']", "66"); // stepKey: setMsrpForSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: setMsrpForSecondChildProductWaitForPageLoad
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButton1
		$I->waitForPageLoad(30); // stepKey: clickDoneButton1WaitForPageLoad
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Go to store front and check msrp for products");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToConfigProductPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadConfigProductPage
		$grabMapPrice = $I->grabTextFrom("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]"); // stepKey: grabMapPrice
		$I->assertEquals("$66.00", ($grabMapPrice)); // stepKey: assertMapPrice
		$I->seeElement("//div[@class='price-box price-final_price']//a[contains(text(), 'Click for price')]"); // stepKey: checkClickForPriceLink
		$I->comment("Check msrp for second child product");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('getConfigAttributeOption2', 'value', 'test')); // stepKey: selectSecondOption
		$I->waitForElement("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]", 30); // stepKey: waitForLoad
		$grabSecondProductMapPrice = $I->grabTextFrom("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]"); // stepKey: grabSecondProductMapPrice
		$I->assertEquals("$66.00", ($grabSecondProductMapPrice)); // stepKey: assertSecondProductMapPrice
		$I->seeElement("//div[@class='price-box price-final_price']//a[contains(text(), 'Click for price')]"); // stepKey: checkClickForPriceLinkForSecondProduct
		$I->comment("Check msrp for first child product");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('getConfigAttributeOption1', 'value', 'test')); // stepKey: selectFirstOption
		$I->waitForElement("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]", 30); // stepKey: waitForLoad1
		$grabFirstProductMapPrice = $I->grabTextFrom("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]"); // stepKey: grabFirstProductMapPrice
		$I->assertEquals("$55.00", ($grabFirstProductMapPrice)); // stepKey: assertFirstProductMapPrice
		$I->seeElement("//div[@class='price-box price-final_price']//a[contains(text(), 'Click for price')]"); // stepKey: checkClickForPriceLinkForFirstProduct
		$I->comment("Check price for third child product");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('getConfigAttributeOption3', 'value', 'test')); // stepKey: selectThirdOption
		$I->waitForElement("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]", 30); // stepKey: waitForLoad2
		$grabThirdProductMapPrice = $I->grabTextFrom("div.price-box.price-final_price"); // stepKey: grabThirdProductMapPrice
		$I->assertEquals("$70.00", ($grabThirdProductMapPrice)); // stepKey: assertThirdProductMapPrice
		$I->dontSeeElement("//div[@class='price-box price-final_price']//a[contains(text(), 'Click for price')]"); // stepKey: checkClickForPriceLinkForThirdProduct
	}
}
