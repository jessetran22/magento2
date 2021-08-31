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
 * @Title("MC-14725: Add simple product with all types of custom options to cart without selecting any options")
 * @Description("Add simple product with all types of custom options to cart without selecting any options<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StoreFrontAddProductWithAllTypesOfCustomOptionToTheShoppingCartWithoutAnySelectedOptionTest.xml<br>")
 * @TestCaseId("MC-14725")
 * @group mtf_migrated
 */
class StoreFrontAddProductWithAllTypesOfCustomOptionToTheShoppingCartWithoutAnySelectedOptionTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
		$I->updateEntity("createProduct", "hook", "productWithOptions",[]); // stepKey: updateProductWithCustomOptions
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Shopping Cart"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontAddProductWithAllTypesOfCustomOptionToTheShoppingCartWithoutAnySelectedOptionTest(AcceptanceTester $I)
	{
		$I->comment("Open Product page in StoreFront");
		$I->comment("Entering Action Group [openProduct1PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct1PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct1PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct1PageAndVerifyProduct
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct1PageAndVerifyProduct
		$I->see($I->retrieveEntityField('createProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct1PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct1PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Click on Add To Cart button");
		$I->click("#product-addtocart-button"); // stepKey: addToCart
		$I->waitForPageLoad(60); // stepKey: addToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Assert all types of product options field displayed Required message");
		$I->comment("Entering Action Group [assertRequiredProductOptionField] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertRequiredProductOptionField
		$I->scrollTo("//div[@class='field required']/label/span[contains(.,'OptionField')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: scrollToElementAssertRequiredProductOptionField
		$I->seeElement("//div[@class='field required']/label/span[contains(.,'OptionField')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: assertElementAssertRequiredProductOptionField
		$I->comment("Exiting Action Group [assertRequiredProductOptionField] AssertStorefrontSeeElementActionGroup");
		$I->comment("Entering Action Group [assertRequiredProductOptionDropDown] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertRequiredProductOptionDropDown
		$I->scrollTo("//div[@class='field required']/label/span[contains(.,'OptionDropDown')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: scrollToElementAssertRequiredProductOptionDropDown
		$I->seeElement("//div[@class='field required']/label/span[contains(.,'OptionDropDown')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: assertElementAssertRequiredProductOptionDropDown
		$I->comment("Exiting Action Group [assertRequiredProductOptionDropDown] AssertStorefrontSeeElementActionGroup");
		$I->comment("Entering Action Group [assertRequiredProductOptionRadioButton] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertRequiredProductOptionRadioButton
		$I->scrollTo("//div[@class='field required']/label/span[contains(.,'OptionRadioButtons')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: scrollToElementAssertRequiredProductOptionRadioButton
		$I->seeElement("//div[@class='field required']/label/span[contains(.,'OptionRadioButtons')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: assertElementAssertRequiredProductOptionRadioButton
		$I->comment("Exiting Action Group [assertRequiredProductOptionRadioButton] AssertStorefrontSeeElementActionGroup");
		$I->comment("Entering Action Group [assertRequiredProductOptionCheckBox] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertRequiredProductOptionCheckBox
		$I->scrollTo("//div[@class='field required']/label/span[contains(.,'OptionCheckbox')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: scrollToElementAssertRequiredProductOptionCheckBox
		$I->seeElement("//div[@class='field required']/label/span[contains(.,'OptionCheckbox')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: assertElementAssertRequiredProductOptionCheckBox
		$I->comment("Exiting Action Group [assertRequiredProductOptionCheckBox] AssertStorefrontSeeElementActionGroup");
		$I->comment("Entering Action Group [assertRequiredProductOptionMultiSelect] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertRequiredProductOptionMultiSelect
		$I->scrollTo("//div[@class='field required']/label/span[contains(.,'OptionMultiSelect')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: scrollToElementAssertRequiredProductOptionMultiSelect
		$I->seeElement("//div[@class='field required']/label/span[contains(.,'OptionMultiSelect')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: assertElementAssertRequiredProductOptionMultiSelect
		$I->comment("Exiting Action Group [assertRequiredProductOptionMultiSelect] AssertStorefrontSeeElementActionGroup");
		$I->comment("Entering Action Group [assertRequiredProductFileOption] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertRequiredProductFileOption
		$I->scrollTo("//div[@class='field file required']/label/span[contains(.,'OptionFile')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: scrollToElementAssertRequiredProductFileOption
		$I->seeElement("//div[@class='field file required']/label/span[contains(.,'OptionFile')]//../../div/div[contains(.,'This is a required field.')]"); // stepKey: assertElementAssertRequiredProductFileOption
		$I->comment("Exiting Action Group [assertRequiredProductFileOption] AssertStorefrontSeeElementActionGroup");
		$I->comment("Entering Action Group [assertRequiredProductDateOption] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertRequiredProductDateOption
		$I->scrollTo("//div[@class='field date required']//span[text()='OptionDate']//../../div/div[contains(.,'This is a required field.')]"); // stepKey: scrollToElementAssertRequiredProductDateOption
		$I->seeElement("//div[@class='field date required']//span[text()='OptionDate']//../../div/div[contains(.,'This is a required field.')]"); // stepKey: assertElementAssertRequiredProductDateOption
		$I->comment("Exiting Action Group [assertRequiredProductDateOption] AssertStorefrontSeeElementActionGroup");
		$I->comment("Entering Action Group [assertRequiredProductDateAndTimeOption] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertRequiredProductDateAndTimeOption
		$I->scrollTo("//div[@class='field date required']//span[text()='OptionDateTime']//../../div/div[contains(.,'This is a required field.')]"); // stepKey: scrollToElementAssertRequiredProductDateAndTimeOption
		$I->seeElement("//div[@class='field date required']//span[text()='OptionDateTime']//../../div/div[contains(.,'This is a required field.')]"); // stepKey: assertElementAssertRequiredProductDateAndTimeOption
		$I->comment("Exiting Action Group [assertRequiredProductDateAndTimeOption] AssertStorefrontSeeElementActionGroup");
		$I->comment("Entering Action Group [assertRequiredProducTimeOption] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertRequiredProducTimeOption
		$I->scrollTo("//div[@class='field date required']//span[text()='OptionTime']//../../div/div[contains(.,'This is a required field.')]"); // stepKey: scrollToElementAssertRequiredProducTimeOption
		$I->seeElement("//div[@class='field date required']//span[text()='OptionTime']//../../div/div[contains(.,'This is a required field.')]"); // stepKey: assertElementAssertRequiredProducTimeOption
		$I->comment("Exiting Action Group [assertRequiredProducTimeOption] AssertStorefrontSeeElementActionGroup");
		$I->comment("Verify mini cart is empty");
		$I->comment("Entering Action Group [assertEmptryCart] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertEmptryCart
		$I->scrollTo("//div[@class='minicart-wrapper']//span[@class='counter qty empty']/../.."); // stepKey: scrollToElementAssertEmptryCart
		$I->seeElement("//div[@class='minicart-wrapper']//span[@class='counter qty empty']/../.."); // stepKey: assertElementAssertEmptryCart
		$I->comment("Exiting Action Group [assertEmptryCart] AssertStorefrontSeeElementActionGroup");
	}
}
