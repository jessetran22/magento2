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
 * @Title("MC-35133: Customer should be able to see only one validation message for checkbox option group")
 * @Description("Customer should be able to see only one validation message for checkbox option group<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontBundleCheckBoxOptionValidationTest.xml<br>")
 * @TestCaseId("MC-35133")
 * @group Bundle
 */
class StorefrontBundleCheckBoxOptionValidationTestCest
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
		$I->createEntity("simpleProduct1", "hook", "ApiProductWithDescription", [], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "ApiProductWithDescription", [], []); // stepKey: simpleProduct2
		$I->createEntity("bundleProduct", "hook", "ApiBundleProduct", [], []); // stepKey: bundleProduct
		$I->createEntity("checkboxBundleOption", "hook", "CheckboxOption", ["bundleProduct"], []); // stepKey: checkboxBundleOption
		$createBundleLink1Fields['qty'] = "2";
		$I->createEntity("createBundleLink1", "hook", "ApiBundleLink", ["bundleProduct", "checkboxBundleOption", "simpleProduct1"], $createBundleLink1Fields); // stepKey: createBundleLink1
		$createBundleLink2Fields['qty'] = "4";
		$I->createEntity("createBundleLink2", "hook", "ApiBundleLink", ["bundleProduct", "checkboxBundleOption", "simpleProduct2"], $createBundleLink2Fields); // stepKey: createBundleLink2
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("bundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
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
	 * @Features({"Bundle"})
	 * @Stories({"Bundle product validation before add to cart"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontBundleCheckBoxOptionValidationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductStorefront] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('bundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductStorefront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductStorefront
		$I->comment("Exiting Action Group [openProductStorefront] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [customizeBundleProduct] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonCustomizeBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonCustomizeBundleProductWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonCustomizeBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonCustomizeBundleProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCustomizeBundleProduct
		$I->comment("Exiting Action Group [customizeBundleProduct] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->comment("Entering Action Group [addToCartBundleProduct] StorefrontAddToTheCartButtonActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartBundleProduct
		$I->waitForElementVisible("#product-addtocart-button", 30); // stepKey: waitForAddToCartButtonAddToCartBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartButtonAddToCartBundleProductWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddToCartBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAddToCartButtonAddToCartBundleProductWaitForPageLoad
		$I->comment("Exiting Action Group [addToCartBundleProduct] StorefrontAddToTheCartButtonActionGroup");
		$I->comment("Entering Action Group [assertBundleValidationCount] AssertStorefrontBundleValidationMessagesCountActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertBundleValidationCount
		$I->seeElement("#validation-message-box"); // stepKey: seeErrorBoxAssertBundleValidationCount
		$I->seeNumberOfElements("#validation-message-box", "1"); // stepKey: seeOneErrorBoxAssertBundleValidationCount
		$I->comment("Exiting Action Group [assertBundleValidationCount] AssertStorefrontBundleValidationMessagesCountActionGroup");
		$I->comment("Entering Action Group [assertBundleValidationMessage] AssertStorefrontBundleValidationMessageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertBundleValidationMessage
		$I->see("Please select one of the options.", "#validation-message-box"); // stepKey: seeErrorHoldMessageAssertBundleValidationMessage
		$I->comment("Exiting Action Group [assertBundleValidationMessage] AssertStorefrontBundleValidationMessageActionGroup");
	}
}
